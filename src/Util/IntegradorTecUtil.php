<?php 
    namespace App\Util;
    use App\Model\Entity\FaturamentoBaixa;
    use App\Model\Entity\Faturamento;
    use App\Model\Entity\Banco;
    use App\Model\Entity\ParametroGeral;
    use App\Util\LeitorArquivosUtil;
    use App\Util\RealNumberUtil;
    use App\Util\DateUtil;
    use Cake\Core\Configure;
    use Cake\ORM\TableRegistry;
use ParametroGerais;

class IntegradorTecUtil {
        private $data;
        public function LoadDataFromFile($name){
            $this->data = LeitorArquivosUtil::getDataAsArray($name);
        }

        private function processData(){
            $aData = [];
            $idA = $idG = $idZ = 0;

            $i = 0;

            foreach ($this->data as $key => $content) {
                
                if ($content[0] == 'A') {
                    $aData['A'][] = $this->typeA($content, $idA);
                    $idA++;
                }else if ($content[0] == 'G') {
                    
                    $aData['G'][$i] = $this->typeG($content, $idG);
                    $idG = $idG ? $idG + 1 : 1;
                    $i++;

                }else if ($content[0] == 'Z') {
                    $aData['Z'][] = $this->typeZ($content, $idZ);
                    $idZ++;
                }else {
                    
                }

            }
            
            return $aData;
        }

        public function getResultAsJson(){
            return json_encode($this->processData());
        }

        public function getResultAsArray(){
            return $this->processData();
        }

        private function processContent($content, $aData){
            

            
        }

        /**
         * TypeA
         * HEADER
         */
        private function typeA($content, $id){
            return [
                'id'            => $id,
                'remessa'       => $content[        self::positon(2)],
                'convenio'      => substr($content, self::positon(3),  20),
                'orgao'         => substr($content, self::positon(23), 20),
                'codigo_banco'  => substr($content, self::positon(43), 3),
                'nome_banco'    => substr($content, self::positon(46), 20),
                'data_criacao'  => substr($content, self::positon(66), 8),
                'NSA'           => substr($content, self::positon(74), 6),
                'versao'        => substr($content, self::positon(80), 2),
                'codigo_barra'  => substr($content, self::positon(99), 17),
            ];
        }

        /**
         * TypeG 
         * RETORNO DAS ARRECADAÇÕES IDENTIFICADAS COM CÓDIGO DE BARRAS
         */
        private function typeG($content, $id){
            return [
                'id'                    => $id,
                'dados_bancarios'       => substr($content, self::positon(2),   20),
                'data_pagamento'        => substr($content, self::positon(22),  8),
                'data_credito'          => substr($content, self::positon(30),  8),
                'codigo_barra'          => substr($content, self::positon(38),  44),
                'valor_recebido'        => substr($content, self::positon(82),  12),
                'valor_tarifa'          => substr($content, self::positon(94),  7),
                'NRS'                   => substr($content, self::positon(101), 8),
                'agencia_arrecadora'    => substr($content, self::positon(109), 8),
                'forma_arrecadacao'     => $content[        self::positon(117)],
                'transacao'             => substr($content, self::positon(2), 23),
                'form_pagamento'        => $content[        self::positon(2)],
                'processado'            => false
            ];
        }

        /**
         * TypeZ
         * TRAILLER
         */
        private function typeZ($content, $id){
            return [
                'id'             => $id,
                'total_dados'    => substr($content, self::positon(2), 6),
                'valor_recebido' => substr($content, self::positon(8), 17)
            ];
        }

        public static function init(){
            $table = TableRegistry::locator()->get('RetornoLeituras');
            $parametersTable = TableRegistry::locator()->get('ParametroGerais');
            $integrador = new IntegradorTecUtil();
            $filesNames = LeitorArquivosUtil::getNameFiles($parametersTable);

            if (!count($filesNames))
                return [
                    'message'   => 'Não há arquivos na fila a serem lidos!',
                    'status'    => 404,
                    'dataExtra' => []
                ];

            foreach ($filesNames as $name) {
                try{
                    $path = LeitorArquivosUtil::getPathFilesNotProcess($name, $parametersTable);
                    $integrador->LoadDataFromFile($path);
                    $data = $integrador->processData();

                    $oRetornoLeituraExistente = LgDbUtil::getFind('RetornoLeituras')
                        ->where(['arquivo_nome' => $name])
                        ->order(['id' => 'DESC'])
                        ->limit(1000)
                        ->first();

                    if ($oRetornoLeituraExistente) {
                        LeitorArquivosUtil::moveFile($path, $name, $parametersTable);
                        throw new \Exception("A leitura deste arquivo já foi feita! ID: ". $oRetornoLeituraExistente->id, 1);
                    }

                    $sucesso = self::saveIntegration($name, $data, $table);

                    if($sucesso){
                        LeitorArquivosUtil::moveFile($path, $name, $parametersTable);
                    }
                } catch (\Throwable $th) {
                    return self::saveErrorIntegration($name, $th, $table);
                }
            }

            return [
                'message' => 'OK',
                'status'  => 200,
                'dataExtra' => [
                    'numero_arquivos_processados' => count($filesNames)
                ]
            ];
        }

        public static function positon($codigo){
            return $codigo- 1;
        }

        public static function saveIntegration($fileName, $data, $table){
            $entity = $table->newEntity([
                'arquivo_nome' => $fileName,
                'data_leitura' => new \Datetime('now'),
                'status'       => 1,
                'tipo'         => 1,
                'dados'        => json_encode($data)
            ]); 
            
            $table->save($entity);

            return true;
        }

        public static function saveErrorIntegration($fileName, $error, $table){
            $sError = '';

            try {
                $sError = $error->getMessage();
            } catch (\Throwable $th) {
                $sError = json_encode($error);
            }

            $entity = $table->newEntity([
                'arquivo_nome' => $fileName,
                'data_leitura' => new \Datetime('now'),
                'status'       => -1,
                'tipo'         => 1,
                'erros'        => $sError
            ]);             
            $table->save($entity);
            return false;
        }

        private static function vinculaProcessados($aTypeGProcessados, $aTypeGs)
        {
            $aTypeGs = json_decode(json_encode($aTypeGs));

            if(empty($aTypeGProcessados)) 
                return $aTypeGs;
            
            foreach ($aTypeGProcessados as $key => $aTypeGProcessado) {

                foreach ($aTypeGs as $key => $aTypeG) {
                    if ($aTypeGs[$key]->id == $aTypeGProcessado->id){
                        $aTypeGs[$key]->processado = $aTypeGProcessado->processado;
                        break;
                    }
                }
            }

            return $aTypeGs;
        }

        public static function processDataFromSkyline(){
            $oLeiturasTable = TableRegistry::getTableLocator()
                ->get('RetornoLeituras');

            $aData = $oLeiturasTable->find()
                ->where([
                    'status IN'     => [1, 3],
                    'tipo'          => 1,
                    'tentativas <'  => 3,
                ])
                /*->where([
                    'id' => 1835
                ])*/
                ->toArray();

            $uCodigo = self::getParameterPTN();

            if(empty($aData)){
                return (new ResponseUtil())
                    ->setStatus(402)
                    ->setMessage(__('Não há nada na fila para ser processado!'));
            }

            // atualiza os IDs
            foreach ($aData as $oRetornoLeitura) {
                $aDadosNexxera = json_decode($oRetornoLeitura->dados);
                $iItemID = 0;

                $aTypeGs = @$aDadosNexxera->G;

                if (!$aTypeGs) continue;

                foreach ($aTypeGs as $oTypeG) {
                    $iItemID++;
                    $oTypeG->id = $iItemID;
                }

                $oRetornoLeitura->dados = json_encode($aDadosNexxera);

                LgDbUtil::save('RetornoLeituras', $oRetornoLeitura);
            }

            $aRetornosProcessados = [];

            $bResult = true;
            $aRespostas = [];
            foreach ($aData as $oItem) {
                $oItem->status = 3;
                $oItem->erros  = null;
                $oItem->tentativas += 1;
                $oItem->data_processamento = new \DateTime('now');
                $oResponse = self::doSkyline($oItem, $uCodigo, $aRetornosProcessados);
                
                if($oResponse->getStatus() == 200) 
                    $oItem->status = 2;

                $aData = $oResponse->getDataExtra();
                $oItem = @$aData['item'] ?:$oItem;
                $aData['item'] = $oItem->id;
                $oLeiturasTable->save($oItem);
                $bResult = $oResponse->getStatus() != 200 ? false :$bResult;
                $aRespostas[] = $oResponse->setDataExtra($aData);
            }

            if ($bResult) return (new ResponseUtil())
                ->setMessage(__('Sucesso! Todos os retornos foram processados!'))
                ->setStatus(200)
                ->setDataExtra([
                    'numero_faturamentos_baixados' => count($aRetornosProcessados) . ' => ' . implode(', ', $aRetornosProcessados),
                    'respostas' => $aRespostas
                ]);
            
            return (new ResponseUtil())
                ->setMessage(
                    __('Houve algum problema ao processar os retornos, verificar a Stack na tabela de retornos!')
                )
                ->setDataExtra([
                    'numero_faturamentos_baixados' => count($aRetornosProcessados) . ' => ' . implode(', ', $aRetornosProcessados),
                    'respostas' => $aRespostas
                ]);
        }

        private static function doSkyline($oRetornoLeitura, $uCodigo, &$aRetornosProcessados){
            $aTypes  = json_decode($oRetornoLeitura->dados);

            try {
                
                if(empty($aTypes)){
                    return (new ResponseUtil())
                        ->setStatus(401)
                        ->setMessage("Falha ao converter os dados do item.");
                }

                if(empty($aTypes->G)){
                    return (new ResponseUtil())
                        ->setStatus(402)
                        ->setMessage("Falha ao localizar o dados do tipo G no arquivo.");
                }

                $aTypeGs = json_decode(json_encode($aTypes->G)); // deslinka objeto da memoria com o antigo

                if(empty($aTypeGs)){
                    return (new ResponseUtil())
                        ->setStatus(403)
                        ->setMessage("Falha ao converter os dados do tipo G no arquivo.");
                }

                $oResponse  = self::analisySkyline($aTypes, $uCodigo, $oRetornoLeitura->id);

                $aData = $oResponse->getDataExtra();

                $aTypeGsAtualizados = self::vinculaProcessados(
                    @$aData['type_g_processados'], $aTypeGs
                );
                $aTypes->G = json_decode(json_encode($aTypeGsAtualizados));
                
                if($oResponse->getStatus()!= 200){
                    $oRetornoLeitura->dados = json_encode($aTypes);
                    return $oResponse->setDataExtra([
                        'item' => $oRetornoLeitura,
                        'data' => $aData
                    ]);
                } 

                //salva erros
                foreach ($aData['type_g_nao_processados'] as $iIDTypeG => $oContent) {
                    foreach ($aTypes->G as $keyType => $aType) {
                        if ($aType->id == $iIDTypeG) {
                            $aTypes->G[$keyType]->processado = false;
                            $aTypes->G[$keyType]->error_message = $oContent->error_message;
                            $oRetornoLeitura->dados = json_encode($aTypes);
                            LgDbUtil::save('RetornoLeituras', $oRetornoLeitura);
                            break;
                        }
                    }
                }

                if(empty($aData['data']))
                    return (new ResponseUtil())
                        ->setMessage("Não existe baixas a serem salvas.")
                        ->setStatus(404)
                        ->setDataExtra([
                            'item'      => $oRetornoLeitura,
                            'data'      => $aData,
                        ]);

                $aBaixas = [];

                foreach ($aData['data'] as $data) {
                    $oBaixa  = LgDbUtil::get('FaturamentoBaixas')->newEntity($data);
                    $bResult = LgDbUtil::save('FaturamentoBaixas', $oBaixa);   
                    
                    if(empty($bResult)) return (new ResponseUtil())
                        ->setMessage('Falha ao salvar a dados Baixa da Automatica.')
                        ->setDataExtra([
                            'item'      => $oRetornoLeitura,
                            'data'      => $aData,
                            'baixas'    => [$oBaixa]
                        ]);

                    $aRetornosProcessados[] = $oBaixa->faturamento_id;
                    $aBaixas[] = $oBaixa->id;
                    //salva que foi processada a sub-linha de retorno
                    foreach ($aTypes->G as $keyType => $aType) {
                        if ($aType->id == $oBaixa->id_json_retorno) {
                            $aTypes->G[$keyType]->processado = true;
                            $aTypes->G[$keyType]->faturamento_baixa_id = $bResult->id;
                            $oRetornoLeitura->dados = json_encode($aTypes);
                            LgDbUtil::save('RetornoLeituras', $oRetornoLeitura);
                            break;
                        }
                    }
                }

                return (new ResponseUtil())
                    ->setStatus(200)
                    ->setDataExtra([
                        'item'      => $oRetornoLeitura,
                        'data'      => $aData,
                        'baixas'    => $aBaixas
                    ]);

            } catch (\Throwable $th) {
                $oRetornoLeitura->status  = 3;
                $oRetornoLeitura->error   = $th;
                return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage($th->getMessage())
                    ->setError($th)
                    ->setDataExtra(['item' => $oRetornoLeitura]);
            }
        }

        private static function analisySkyline($item, $codigo, $iRetornoLeituraID){
            $aTypeGProcessados = array();
            $aTypeGNaoProcessados = array();
            $oTable = LgDbUtil::get('Faturamentos');
            $iID = 0;

            try {
                $iID = 1;
                $aEntities = [];
                
                foreach ($item->G as $key => $content) {

                    $content->id = $iID++;

                    if ($content->processado)
                        continue;
                    
                    $payment_bank_code = str_replace(' ', '', $item->A[0]->codigo_banco);

                    $bankData = explode(' ', trim($content->dados_bancarios));
                    $payment_date = DateUtil::dateFromIntegration($content->data_pagamento);
                    $payment_value = RealNumberUtil::convertNumberFromIntegration($content->valor_recebido);
                    $sequence = (int) $content->NRS;
                    $payment_type = (int) $content->forma_arrecadacao;
                    $count_primario =  substr($content->codigo_barra, -15, -3);
                    $count_secundario =  substr($content->codigo_barra, -3, 2);
                    $count_dv =  substr($content->codigo_barra, -1);

                    $tipoFaturamento =  substr($content->codigo_barra, -16, -15);
                    $code =  substr($content->codigo_barra, -15, -12);
                    $banco_id = $oTable->FaturamentoBaixas->Bancos
                        ->find()->where([ 'codigo' => $payment_bank_code ])->first();
                    $banco_id = $banco_id ? $banco_id->id : null;

                    $sFormPagamento = str_replace(' ', '', $content->form_pagamento);

                    $tipo_pagamento = $oTable->FaturamentoBaixas->TipoPagamentos
                        ->find()->where(['id' => $sFormPagamento ?:0])->first();

                    $tipo_pagamento = ($tipo_pagamento) ? $tipo_pagamento->id : 4;

                    $oExistsTipoFaturamento = $oTable->TiposFaturamentos
                        ->find()->where(['id' => $tipoFaturamento ?: 0])->first();

                    if (!$tipoFaturamento || !$oExistsTipoFaturamento)  {
                        $content->error_message = "Não encontramos esse tipo de faturamento (codigo_barras: ".$content->codigo_barra.") ($tipoFaturamento) ou ele veio incorreto no codigo de barras";
                        $aTypeGNaoProcessados[$content->id] = $content;
                        continue;
                    }

                    // if($code == $codigo){
                        
                        $sTipoDescricao = strtolower($oExistsTipoFaturamento->descricao);
                        $sCampoPrimarioViaTipo = 'count_' . $sTipoDescricao . '_primario'; 
                        $sCampoSecundarioViaTipo = 'count_' . $sTipoDescricao . '_secundario'; 

                        $aWhere = [ 
                            'count_generic_primario'    => $count_primario,
                            'count_generic_secundario'  => $count_secundario,
                            'count_generic_dv'          => $count_dv,
                        ];

                        $billing = $oTable
                            ->find()
                            ->where($aWhere)
                            ->first();

                        if(!$billing) continue;

                        $valor_acumulado_servicos = $oTable->FaturamentoServicos->find()
                            ->select(
                                ['acumulado_servicos' => $oTable->FaturamentoServicos->find()->func()->sum('valor_total')]
                            )
                            ->where([
                                'faturamento_id' => $billing->that['id']?:0
                            ])
                            ->group('faturamento_id')
                            ->first();
                            
                        $valor_acumulado_servicos = ($valor_acumulado_servicos) 
                            ? $valor_acumulado_servicos->acumulado_servicos
                            : 0;

                        $faturamento_arm_id = $oTable->FaturamentoArmazenagens->find()
                            ->where([
                                'ROUND(valor_acumulado_servico, 2) = '. round((double) $payment_value, 2),
                                'faturamento_id'  => $billing->that['id']?:0
                            ])
                            ->toArray();

                        $faturamento_arm_id = array_pop($faturamento_arm_id);
                        $valor_sem_arm_encontrada = null;
                        
                        if (!$faturamento_arm_id) {
                            $valor_sem_arm_encontrada = 1;
                            //throw new \Exception("O valor pago pelo cliente '" . (double) $payment_value . "' não foi encontrado em nenhuma armazenagem do faturamento ID = " . $billing->that['id'] . ' valor que foi tentado encontrar = valor_acumulado_armazenagem + valor_acumulado_servicos(' . $valor_acumulado_servicos . ') ' . $valor_acumulado, 1);
                        }
                            
                        $aux_content = json_decode(json_encode($content));

                        $entity = [
                            'tipo_baixa'                 => 'automatico nexxera',
                            'sequencia_baixa'            => $sequence,
                            'data_baixa'                 => $payment_date,
                            'banco_id'                   => $banco_id,
                            'agencia'                    => @$bankData[0],
                            'conta'                      => @$bankData[1].@$bankData[2].@$bankData[3]?:@$bankData[0],
                            'valor_baixa'                => $payment_value,
                            'tipo_pagamento_id'          => $payment_type == 3 ? 2 : $payment_type,
                            'codigo_banco'               => $payment_bank_code,
                            'faturamento_id'             => $billing->that['id'],
                            'faturamento_armazenagem_id' => $faturamento_arm_id ? $faturamento_arm_id->id : null,
                            'valor_sem_arm_encontrada'   => $valor_sem_arm_encontrada,
                            'retorno_leitura_id'         => $iRetornoLeituraID,
                            'id_json_retorno'            => @$aux_content->id,
                            'tipo_pagamento_id'          => $tipo_pagamento
                        ];

                        $aTypeGProcessados[] = $aux_content;
                        $aEntities[] = $entity;
                    // }
                }

                return (new ResponseUtil())
                    ->setStatus(200)
                    ->setDataExtra([
                        'data' => $aEntities, 
                        'type_g_processados' => $aTypeGProcessados,
                        'type_g_nao_processados' => $aTypeGNaoProcessados,
                    ]);

            }catch (\Throwable $th) {
                return (new ResponseUtil())
                    ->setMessage($th->getMessage())
                    ->setStatus(500)
                    ->setError($th)
                    ->setDataExtra([
                        'data' => $aEntities, 
                        'type_g_processados' => $aTypeGProcessados,
                        'type_g_nao_processados' => $aTypeGNaoProcessados,
                    ]);
            }
        }

        private static function connectToServer($oIntegracao){
            $servidor = $oIntegracao->db_host?:'';
            $usuario = $oIntegracao->db_user?:'';
            $senha = $oIntegracao->db_pass?:'';
            $porta = $oIntegracao->db_porta?:21;
            $ftp = ftp_connect($servidor, $porta);

            if(!$ftp){
                return false;
            }

            $login = ftp_login($ftp, $usuario, $senha); 

            if(!$login){
                return false;
            }

            return $ftp;
        }


        private static function closeConnection($conn){
            ftp_close($conn);
        }


        public static function getDataFromServer(){

            $oIntegracao = LgDbUtil::getFirst('integracoes', ['codigo_unico' => 'nexxera']);

            if(empty($oIntegracao)) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('Falha ao localizar os dados da integração do Nexxera.');

            if(empty($oIntegracao->ativo)) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('A integração do Nexxera está desativada, por favor habilitar.');

            $aParametros = json_decode($oIntegracao->json_parametros, true);

            if(empty($aParametros)) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('Parâmetros da Integração inválidos.');

            if(empty($aParametros)) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('Parâmetros da Integração inválidos.');

            if(empty($aParametros['raiz'])) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('O endereço do diretório da raiz está vazio.');

            if(empty($aParametros['arquivos'])) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('O endereço do diretório dos arquivos está vazio.');

            if(empty($aParametros['destino'])) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('O endereço do diretório dos destino está vazio.');

            $sTipo = ParametroGeral::getParametroWithValue('PARAM_HABILITA_INTEGRACAO_NEXXERA');

            switch ($sTipo) {
                case 'ftp': return self::getDataFromFtp($oIntegracao, $aParametros);
                case 'directory': return self::getDataFromDirectory($oIntegracao, $aParametros);
                default: return (new ResponseUtil())
                    ->setStatus(404)
                    ->setMessage('Tipo de integração não localizada.');
            }
        }

        private static function getDataFromDirectory($oIntegracao, $aParametros){
            $sDiretorioRaiz     = @$aParametros['raiz']?:'';
            $sDiretorioArquivos = @$aParametros['arquivos']?:'';
            $sDiretorioDestino  = @$aParametros['destino']?:'';
            $sDiretorioToCopy   = LeitorArquivosUtil::getPath();
            $aArquivos  = [];
            $aCopiados  = [];
            $aMovidos   = []; 

            if(!is_dir($sDiretorioRaiz)) 
                return (new ResponseUtil())
                    ->setMessage('A endereço do diretório não foi encontrado.');
                
            if(!is_dir($sDiretorioArquivos))
                return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('A endereço do diretório dos arquivos não foi encontrado.');

            if(!is_dir($sDiretorioToCopy))
                return (new ResponseUtil())
                    ->setMessage('A endereço do diretório para a copia dos arquivos não encontrado.');

            $oResponse = self::getDiretorioDestino($sDiretorioRaiz, $sDiretorioDestino);
            if($oResponse->getStatus() != 200) return $oResponse;
            $sDestino = $oResponse->getDataExtra();
            
            try {
            
                $oDiretorioArquivos = dir($sDiretorioArquivos);

                while (false !== ($sNameArquivo = $oDiretorioArquivos->read())) {
                    $sFileDir = $oDiretorioArquivos->path. DS .$sNameArquivo;
                    if(in_array($sNameArquivo, ['.', '..'])) continue;
                    if(!is_file($sFileDir)) continue;

                    $aArquivos[] = $sNameArquivo;

                    if(copy($sFileDir, $sDiretorioToCopy. DS .$sNameArquivo)){
                        $aCopiados [] = $sNameArquivo;

                        $aData = LeitorArquivosUtil::getDataAsArray(
                            $sDiretorioToCopy. DS .$sNameArquivo
                        );
                        
                        if(empty($aData)) continue;

                        $sBancoCodigo = array_reduce($aData, function ($somador , $content){
                            return @$content[0] == 'A' ? trim(substr($content, self::positon(43), 3)): $somador;
                        }, '');

                        if(empty($sBancoCodigo)) continue;

                        $sDestinoFinal = $sDestino. DS . $sBancoCodigo;

                        if(!is_dir($sDestinoFinal)){
                            if(!mkdir($sDestinoFinal)) continue;
                            if(!is_dir($sDestinoFinal)) continue;
                        }

                        $sNomeArquivoDestino = $sDestinoFinal . DS . $sNameArquivo . '__-__date-' . date('Y-m-d-H-i-s-') . time();

                        if(@rename($sFileDir, $sNomeArquivoDestino))
                            $aMovidos[] = $sNameArquivo;

                        try {
                            if (file_exists($sFileDir) && @copy($sFileDir, $sNomeArquivoDestino)) {
                                unlink($sFileDir);

                                if (!in_array($sNameArquivo, $aMovidos))
                                    $aMovidos[] = $sNameArquivo;
                            }
                        } catch (\Throwable $th) { 
                            
                        }
                    }
                }

                $oDiretorioArquivos->close(); 

                return (new ResponseUtil())->setStatus(200)->setDataExtra([
                    'arquivos'  => $aArquivos,
                    'copiados'  => $aCopiados,
                    'movidos'   => $aMovidos
                ]);

            } catch (\Throwable $th) {
                return (new ResponseUtil())->setStatus(500)->setMessage($th->getMessage());       
            }
        }

        private static function getDiretorioDestino($sRaiz, $sDestino){

            
            if(!is_dir($sDestino)) return (new ResponseUtil())
                ->setMessage('O endereço do diretório de destino não foi encontrado.');

            $sDirAno = 'BK'.date('Y');
            $sDiretorio = $sDestino . DS . $sDirAno;

            if(!is_dir($sDiretorio)){

                if(!mkdir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno");

                if(!is_dir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno");
            }

            $sDirAnoMes = 'BK'.date('Ym');
            $sDiretorio = $sDestino . DS . $sDirAno . DS . $sDirAnoMes;

            if(!is_dir($sDiretorio)){

                if(!mkdir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno => $sDirAnoMes");

                if(!is_dir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno => $sDirAnoMes ");
            }

            $sDirMesDia = 'BK'.date('md');
            $sDiretorio = $sDestino . DS . $sDirAno . DS . $sDirAnoMes . DS . $sDirMesDia;

            if(!is_dir($sDiretorio)){

                if(!mkdir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno => $sDirAnoMes => $sDirMesDia");


                if(!is_dir($sDiretorio)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno => $sDirAnoMes => $sDirMesDia");
            }

            return (new ResponseUtil())->setStatus(200)->setDataExtra($sDiretorio);
        }

        private static function getDataFromFtp($oIntegracao, $aParametros){

            if(empty(self::setDirLocal())) 
                return (new ResponseUtil())
                    ->setStatus(402)
                    ->setMessage('Falha ao localizar o diretório para salvar os arquivos!');
                
            $conn = self::connectToServer($oIntegracao);

            if(empty($conn)) return (new ResponseUtil())
                ->setStatus(401)
                ->setMessage('Falha na conexão com o FTP!')
                ->setDataExtra(['conn' => $conn]);

            try {

                ftp_pasv($conn, true);
                $oResponse = self::getFilesFromFTPServer($conn, $aParametros);
                self::closeConnection($conn);

                if($oResponse->getStatus() == 200){
                    $aData = $oResponse->getDataExtra();
                    $aNomes = $aData['arquivos']?:[];
                    return $oResponse->setDataExtra([
                        'total' => count($aNomes),
                        'numero_arquivos_movidos'  => implode(', ', $aNomes),
                        'data' => $aData
                    ]);
                }

                return $oResponse;
                
            } catch (\Throwable $th) {

                return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage('Falha na busca dos arquivos do FTP!')
                    ->setDataExtra([
                        'error_stack' => $th->getMessage(),
                    ]);
            }
        }

        private static function getFilesFromFTPServer($conn, $aParametros){ 
            $sDiretorioRaiz     = @$aParametros['raiz']?:'';
            $sDiretorioArquivos = @$aParametros['arquivos']?:'';
            $sDiretorioDestino  = @$aParametros['destino']?:'';
            $aNomeArquivos  = [];
            $aCopiaItens    = [];
            $aMovItens      = [];

            $bRaiz = ftp_chdir($conn, $sDiretorioRaiz); // INIT RAIZ
            
            if(empty($bRaiz)) return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage('Falha ao acessar o diretorio Raiz');

            $oResponse = self::getNameFromServer($conn, $sDiretorioArquivos);
            $aNomeArquivos = @$oResponse->getDataExtra()?:[];
            if($oResponse->getStatus() != 200) return $oResponse;

            $oResponse = self::getDiretorioDestinoFtp($conn, $sDiretorioRaiz, $sDiretorioDestino);
            if($oResponse->getStatus() != 200) return $oResponse;
            
            $sDiretorioDestinoFinal = $oResponse->getDataExtra();

            if($oResponse->getStatus() == 200){
                $oResponse = self::copyToLocal($conn, $aNomeArquivos, $sDiretorioRaiz, $sDiretorioArquivos, $sDiretorioDestinoFinal);
            }
              
            ftp_chdir($conn, $sDiretorioRaiz);

            return $oResponse;
        }

        private static function getNameFromServer($conn, $sDiretorioArquivos = ''){
            $bArquivos = ftp_chdir($conn, $sDiretorioArquivos);

            if(empty($bArquivos)) return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage('Falha ao acessar  o diretorio Arquivos');

            $aNames = ftp_nlist($conn, '');

            if(empty($aNames)) return (new ResponseUtil())
                ->setStatus(404)
                ->setMessage('Nenhum arquivo localizado no servidor para copiar.');

            return (new ResponseUtil())
                ->setStatus(200)
                ->setDataExtra($aNames);
        }

        private static function setDirLocal(){
            try {
                $path = LeitorArquivosUtil::getPath();
                return chdir($path);
            } catch (\Throwable $th) {
                return false;
            }
        }

        private static function getDiretorioDestinoFtp($conn, $sRaiz, $sDestino){

            $bReturno = ftp_chdir($conn, $sDestino);

            if(empty($bReturno)) return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage("Falha ao acessar o diretorio destino: $sDestino");

            $sDirAno = 'BK'.date('Y');
            $bReturno = @ftp_chdir($conn, $sDirAno);

            if(empty($bReturno)){

                $bReturno = ftp_mkdir($conn, $sDirAno);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno");

                $bReturno = ftp_chdir($conn, $sDirAno);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno");
            }

            $sDirAnoMes = 'BK'.date('Ym');
            $bReturno = @ftp_chdir($conn, $sDirAnoMes);

            if(empty($bReturno)){
                $bReturno = ftp_mkdir($conn, $sDirAnoMes);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno => $sDirAnoMes");

                $bReturno = ftp_chdir($conn, $sDirAnoMes);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno => $sDirAnoMes ");
            }

            $sDirMesDia = 'BK'.date('md');
            $bReturno = @ftp_chdir($conn, $sDirMesDia);

            if(empty($bReturno)){
                $bReturno = ftp_mkdir($conn, $sDirMesDia);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(500)
                    ->setMessage("Falha ao criar o destino: $sDestino => $sDirAno => $sDirAnoMes => $sDirMesDia");

                $bReturno = ftp_chdir($conn, $sDirMesDia);

                if(empty($bReturno)) return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Falha ao acessar o diretorio de destino: $sDestino => $sDirAno => $sDirAnoMes => $sDirMesDia");
            }

            $sDiretorioFinal = ftp_pwd($conn);

            if(empty($sDiretorioFinal)) return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage("Falha ao listar o diretorio de destino :$sDestino => $sDirAno => $sDirAnoMes => $sDirMesDia");

            ftp_chdir($conn, $sRaiz);

            return (new ResponseUtil())->setStatus(200)->setDataExtra($sDiretorioFinal);
        }

        private static function copyToLocal($conn, $aNomes, $sRaiz = '', $sOrigin = '', $sDestino = ''){
            $bResultadoGeral = true;
            $aCopiados = []; 
            $aMovidos = []; 


            foreach ($aNomes as $name) {

                $bResult = ftp_chdir($conn, $sOrigin);

                if(empty($bResult)) {
                    $bResultadoGeral = false;
                    continue;
                }

                $bResult = ftp_get($conn, $name, $name, FTP_BINARY);

                if(empty($bResult)) {
                    $bResultadoGeral = false;
                    continue;
                }

                $aCopiados[] = $name;

                $bResult =  self::moveFile($conn, $name, $sOrigin, $sDestino);

                if(empty($bResult)) {
                    $bResultadoGeral = false;
                    continue;
                }

                $aMovidos[] = $name;
            }

            ftp_chdir($conn, $sRaiz);

            return (new ResponseUtil())
                ->setStatus($bResultadoGeral ? 200 : 405)
                ->setMessage($bResultadoGeral ? 'Ok' : 'Houve algum problema ao copiar os arquivos.')
                ->setDataExtra([
                    'arquivos' => $aNomes,
                    'copiados' => $aCopiados,
                    'movidos'  => $aMovidos
                ]);
        }

        private static function moveFile($conn, $sNome, $sOrigin, $sDestino){
            $aData = LeitorArquivosUtil::getDataAsArray($sNome);             
            if(empty($aData)) return false;

            $sBancoCodigo = array_reduce($aData, function ($somador , $content){
                return @$content[0] == 'A' ? trim(substr($content, self::positon(43), 3)): $somador;
            }, '');

            $bEntrou = @ftp_chdir($conn, $sDestino . '/'.  $sBancoCodigo);

            if(empty($bEntrou)){
                $bResult = ftp_mkdir($conn, $sDestino . '/'.  $sBancoCodigo);
                if(empty($bResult)) return false;
                $bResult = ftp_chdir($conn, $sDestino . '/'.  $sBancoCodigo);
                if(empty($bResult)) return false;
            }

            $sDestinoFinal = ftp_pwd($conn);

            $bEntrou = ftp_chdir($conn, $sOrigin);
            if(empty($bEntrou)) return false;
            
            return ftp_rename($conn, $sNome, $sDestinoFinal . '/'. $sNome);
        }

        private static function getParameterPTN(){
            return ParametroGeral::getParameterByUniqueName('INT_PTN_NEGRA')->valor;
        }

    }
?>