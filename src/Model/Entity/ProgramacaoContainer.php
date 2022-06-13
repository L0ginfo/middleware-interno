<?php
namespace App\Model\Entity;

use App\RegraNegocio\Container\LiberacaoAutomaticaContainer;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class ProgramacaoContainer extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveProgramacaoContainer($that)
    {
        $oResponse = new ResponseUtil();
        $aRequestData = $that->request->data();

        LiberacaoAutomaticaContainer::do(@$aRequestData['container_id']);

        if (!@$aRequestData['id']) {
            $oReturn = self::verifyExistsContainerInProgramacao($aRequestData['container_id']);
            if ($oReturn->getStatus() == 400)
                return $oReturn;
        }

        $bExisteContainer = EntradaSaidaContainer::verifyIfContainerInEstoque(@$aRequestData['container_id'] ?: null, $aRequestData['operacao_id']);
        if ($bExisteContainer)
            return (new ResponseUtil())
                ->setMessage('Container já esta em estoque.');

        $bContainerNovo = self::checkContainerNovo($aRequestData);
        if ($bContainerNovo) {
            $aRequestData['container_id'] = Container::saveContainerResv($aRequestData);
            if (!$aRequestData['container_id']) {
                return $oResponse
                    ->setStatus(400)
                    ->setMessage('Erro ao cadastrar um novo container VAZIO')
                    ->setDataExtra([])
                    ->setTitle('Ops...!');
            }
        }

        $oReturn = ResvsContainer::verifyAddContainerResvCarga($aRequestData);
        if ($oReturn->getStatus() == 400)
            return $oReturn;

        $aRequestData['liberacao_documental_id'] = null;
        if ($oReturn->getStatus() == 200) {
            $aLiberacaoDocumentais = $oReturn->getDataExtra();

            foreach ($aLiberacaoDocumentais as $oLiberacaoDocumental) {
                $aRequestData['liberacao_documental_id'] = $oLiberacaoDocumental->id;
                $aRequestData['empresa_id']              = $oLiberacaoDocumental->cliente_id;
                $oProgramacaoLiberacaoDocumental = LgDbUtil::getFind('ProgramacaoLiberacaoDocumentais')
                    ->where([
                        'programacao_id' => $aRequestData['programacao_id'],
                        'liberacao_documental_id' => $oLiberacaoDocumental->id
                    ])
                    ->first();
    
                if (!$oProgramacaoLiberacaoDocumental)
                    LgDbUtil::saveNew('ProgramacaoLiberacaoDocumentais', [
                        'programacao_id' => $aRequestData['programacao_id'],
                        'liberacao_documental_id' => $oLiberacaoDocumental->id
                    ]);
            }
        }

        if($aRequestData['drive_espaco_id']) {
            $oDriveEspaco = LgDbUtil::getFirst('DriveEspacos', ['id' => $aRequestData['drive_espaco_id']]);
            $bCheckQtdeContainer = DriveEspaco::checkQtdeContainer($oDriveEspaco, $aRequestData['operacao_id'], $aRequestData['tipo_container']);

            if($bCheckQtdeContainer->status !== 200) {
                return (new ResponseUtil())
                    ->setStatus(405)
                    ->setMessage($bCheckQtdeContainer->message);
            }
        }

        $iOperacaoDescargaID = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga');
        $oResponseDocs = new ResponseUtil();
        if ($aRequestData['operacao_id'] == $iOperacaoDescargaID && $aRequestData['tipo_container'] == 'CHEIO') {

            $oResponse = self::verifyContainerAgendado($aRequestData);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $iClienteID = self::getClienteIdByDocumentoMercadoria($aRequestData['container_id'], $aRequestData['operacao_id']);
            $aRequestData['empresa_id'] = $iClienteID;

            $oResponseDocs = self::saveProgramacaoDocumentoTransporteByContainer($aRequestData);
            if ($oResponseDocs->getStatus() != 200)
                return $oResponseDocs;

        }
        
        $aData = [
            'id'                      => isset($aRequestData['id']) ? $aRequestData['id'] : null,
            'container_id'            => $aRequestData['container_id'],
            'documento_transporte_id' => $aRequestData['documento_transporte_id'],
            'programacao_id'          => $aRequestData['programacao_id'],
            'operacao_id'             => $aRequestData['operacao_id'],
            'cliente_id'              => @$aRequestData['empresa_id'],
            'liberacao_documental_id' => $aRequestData['liberacao_documental_id'],
            'drive_espaco_id'         => $aRequestData['drive_espaco_id'],
            // 'documento_genericos_id'  => $aRequestData['documento_genericos_id'],
            'tipo'                    => $aRequestData['tipo_container'],
            'container_forma_uso_id'  => $aRequestData['container_forma_uso_id'],
            'super_testado'           => $aRequestData['super_testado'],
            'container_destino_id'    => @$aRequestData['container_destino_id'] ?: NULL,
            'beneficiario_id'         => $aRequestData['beneficiario_id']
        ];

        $aDataLacres = [
            'lacres_json' => $aRequestData['lacres_json']
        ];

        if ($aData['id']) {
            $oProgramacaoContainerEntity = LgDbUtil::get('ProgramacaoContainers')->get($aData['id']);
            $oProgramacaoContainerEntity = LgDbUtil::get('ProgramacaoContainers')->patchEntity($oProgramacaoContainerEntity, $aData);
        } else {
            $oProgramacaoContainerEntity = LgDbUtil::get('ProgramacaoContainers')->newEntity($aData);
        }

        if (array_key_exists('quantidade_vazios', $aRequestData) 
            && $aRequestData['quantidade_vazios'] > 1 
            && !$aData['id'] 
            && !$aRequestData['container_id'] 
            && $aRequestData['operacao_id'] != $iOperacaoDescargaID) {

                $oResponse = self::saveContainersVazios($that, 'ProgramacaoContainers', $aData, $aDataLacres, $aRequestData['quantidade_vazios']);
                return $oResponse;

        }

        if (LgDbUtil::get('ProgramacaoContainers')->save($oProgramacaoContainerEntity)) {

            ProgramacaoContainerLacre::saveProgramacaoContainerLacres($that, $aDataLacres, $oProgramacaoContainerEntity->id, $oResponseDocs->getDataExtra());
            if (@$aRequestData['armador_id'])
                Container::setArmadorByContainer($aRequestData['container_id'], $aRequestData['armador_id']);

            $oProgramacaoContainer = LgDbUtil::get('ProgramacaoContainers')
                ->get($oProgramacaoContainerEntity->id, [
                    'contain' => [
                        'Containers',
                        'DocumentosTransportes',
                        'Operacoes',
                        'Empresas',
                        'DriveEspacos',
                        'ProgramacaoContainerLacres' => [
                            'LacreTipos'
                        ],
                        'Programacoes' => [
                            'ProgramacaoDocumentoTransportes' => [
                                'Programacoes',
                                'DocumentosTransportes' => [
                                    'DocumentosMercadoriasMany' => [
                                        'Clientes'
                                    ]
                                ]
                            ],
                            'ProgramacaoLiberacaoDocumentais' => [
                                'Programacoes',
                                'LiberacoesDocumentais' => ['Clientes'],
                                'LiberacaoDocumentalTransportadoras',
                                'ProgramacaoLiberacaoDocumentalItens'
                            ]
                        ]
                    ]
                ]);

            $aProgDocEntradas = @$oProgramacaoContainer->programacao->programacao_documento_transportes ?: [];
            $aProgDocEntradas = Viagem::getDocEntradas($oProgramacaoContainer->programacao->viagem_id, $aProgDocEntradas);
            $aProgDocSaidas = @$oProgramacaoContainer->programacao->programacao_liberacao_documentais ?: [];
            $aProgDocSaidas = Viagem::getDocSaidas($oProgramacaoContainer->programacao->viagem_id, $aProgDocSaidas);

            $oProgramacaoContainer->doc_entradas = $aProgDocEntradas;
            $oProgramacaoContainer->doc_saidas = $aProgDocSaidas;

            return $oResponse
                ->setStatus(200)
                ->setMessage('Container vinculado na programação com sucesso!')
                ->setDataExtra($oProgramacaoContainer)
                ->setTitle('Sucesso!');
        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao vincular container a programação!')
            ->setDataExtra($oProgramacaoContainerEntity)
            ->setTitle('Ops...!');
    }

    public static function saveContainersVazios($that, $oEntity, $aData, $aDataLacres, $iQuantidade)
    {
        $oResponse = new ResponseUtil();

        for ($i = 0; $i < $iQuantidade ; $i++) { 
            
            $oEntityContainer = LgDbUtil::get($oEntity)->newEntity($aData);

            if (!LgDbUtil::get($oEntity)->save($oEntityContainer))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops...!')
                    ->setMessage('Erro ao vincular container vazio!');

            if ($oEntity == 'ProgramacaoContainers')
                ProgramacaoContainerLacre::saveProgramacaoContainerLacres($that, $aDataLacres, $oEntityContainer->id);

            if ($oEntity == 'ResvsContainers')
                ResvContainerLacre::saveResvContainerLacres($that, $aDataLacres, $oEntityContainer->id);

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Containers vinculados com sucesso!');
    }

    public static function verifyContainerAgendado($aRequestData)
    {
        $oResponse = new ResponseUtil();

        $oProgramacoes = LgDbUtil::getFind('Programacoes')
            ->contain([
                'Resvs',
                'ProgramacaoContainers'
            ])
            ->leftJoinWith('Resvs')
            ->innerJoinWith('ProgramacaoContainers', function ($q) use ($aRequestData) {
                return $q->where([
                    'ProgramacaoContainers.container_id' => $aRequestData['container_id']
                ]);
            })
            ->where([
                'Programacoes.id <>' => $aRequestData['programacao_id'],
                'Resvs.data_hora_saida IS' => null
            ])
            ->toArray();

        if ($oProgramacoes)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que já existe uma programação para esse container!');

        return $oResponse->setStatus(200);
    }

    public static function getClienteIdByDocumentoMercadoria($iContainerID, $iOperacaoID)
    {
        $aDocsMercadorias = self::getDocumentosMercadoriasFromContainer($iContainerID);

        if (!$aDocsMercadorias)
            return null;

        return $aDocsMercadorias[0]->cliente_id;

    }

    private static function getDocumentosMercadoriasFromContainer($iContainerID)
    {
        $aEntradasSaidasContainers = LgDbUtil::getFind('EntradaSaidaContainers')
            ->contain([
                'ResvEntrada' => [
                    'ResvsDocumentosTransportes'
                ], 
                'ResvSaida'
            ])
            ->where([
                'container_id' => $iContainerID
            ])
            ->toArray();

        $aDocsTransportesIDsDescarte = [];
        if ($aEntradasSaidasContainers) {

            foreach ($aEntradasSaidasContainers as $aEntradaSaidaContainer) {

                $aResvDocTransportes = $aEntradaSaidaContainer->resv_entrada->resvs_documentos_transportes;

                $aDocsTransportesIDsDescarte = array_reduce($aResvDocTransportes, function($carry, $oResvDocsTransportes) {
                    $carry[] = $oResvDocsTransportes->documento_transporte_id;
                    return $carry;
                }, []);

            }
            
        }
        
        $aDocsMercadorias = LgDbUtil::getFind('DocumentosMercadorias')
            ->contain([
                'DocumentosTransportes'
            ])
            ->innerJoinWith('DocumentosMercadoriasItens.ItemContainers', function ($q) use ($iContainerID) {
                return $q->where([
                    'ItemContainers.container_id' => $iContainerID
                ]);
            })
            ->where([
                'DocumentosTransportes.id NOT IN' => $aDocsTransportesIDsDescarte ?: 0
            ])
            ->toArray();

        if (!$aDocsMercadorias)
            return null;

        return $aDocsMercadorias;
    }

    public static function saveProgramacaoDocumentoTransporteByContainer($aRequestData) 
    {
        $oResponse = new ResponseUtil();

        $aDocsTransportesIDsInsert = self::getDocumentosTransportesByProgramacoesContainers($aRequestData);
        if (!$aDocsTransportesIDsInsert)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que este Container não tem Documento de Transporte!');

        $aProgramacaoDocEntradas = LgDbUtil::getFind('ProgramacaoDocumentoTransportes')
            ->where(['programacao_id' => $aRequestData['programacao_id']])
            ->toArray();

        foreach ($aDocsTransportesIDsInsert as $key => $value) {

            $bHasDocInProg = array_filter($aProgramacaoDocEntradas, function($oProgDocEntrada) use ($value) {
                return $oProgDocEntrada->documento_transporte_id == $value;
            });

            if ($bHasDocInProg)
                continue;

            $oDocumentosMercadoria = new DocumentosMercadoria();
            $oDocumentosMercadoria->generateLoteCodigo(null, $value);
            
            $aDataInsert = [
                'programacao_id'          => $aRequestData['programacao_id'],
                'documento_transporte_id' => $value,
            ];

            $oProgramacaoDocumentoTransporte = LgDbUtil::getFirst('ProgramacaoDocumentoTransportes', $aDataInsert);
            if (!$oProgramacaoDocumentoTransporte) {
                LgDbUtil::saveNew('ProgramacaoDocumentoTransportes', $aDataInsert);
            }

        }

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aDocsTransportesIDsInsert);
    }

    public static function getDocumentosTransportesByProgramacoesContainers($aRequestData)
    {
        $aEntradasSaidasContainers = LgDbUtil::getFind('EntradaSaidaContainers')
            ->contain([
                'ResvEntrada' => [
                    'ResvsDocumentosTransportes'
                ], 
                'ResvSaida'
            ])
            ->where([
                'container_id' => $aRequestData['container_id']
            ])
            ->toArray();

        $aDocsTransportesIDsDescarte = [];
        if ($aEntradasSaidasContainers) {

            foreach ($aEntradasSaidasContainers as $aEntradaSaidaContainer) {

                $aResvDocTransportes = $aEntradaSaidaContainer->resv_entrada->resvs_documentos_transportes;

                $aAux = array_reduce($aResvDocTransportes, function($carry, $oResvDocsTransportes) {
                    $carry[] = $oResvDocsTransportes->documento_transporte_id;
                    return $carry;
                }, []);

                $aDocsTransportesIDsDescarte = array_merge($aAux, $aDocsTransportesIDsDescarte);
            }
            
        }
        
        $aDocsMercadorias = LgDbUtil::getFind('DocumentosMercadorias')
            ->contain([
                'DocumentosTransportes'
            ])
            ->innerJoinWith('DocumentosMercadoriasItens.ItemContainers', function ($q) use ($aRequestData) {
                return $q->where([
                    'ItemContainers.container_id' => $aRequestData['container_id']
                ]);
            })
            ->where([
                'DocumentosTransportes.id NOT IN' => $aDocsTransportesIDsDescarte ?: 0
            ])
            ->toArray();
            
        if (!$aDocsMercadorias)
            return null;

        $aDocsTransportesIDsInsert = array_reduce($aDocsMercadorias, function($carry, $aDocMercadoria) {
            $carry[] = $aDocMercadoria->documento_transporte_id;
            return $carry;
        }, []);

        return $aDocsTransportesIDsInsert;
    }

    public static function deleteProgramacaoContainer($iProgramacaoContainerID)
    {
        $oResponse = new ResponseUtil();
        $oProgramacaoContainer = LgDbUtil::getFind('ProgramacaoContainers')->where(['ProgramacaoContainers.id' => $iProgramacaoContainerID])->contain(['ProgramacaoContainerLacres'])->first();
        
        if ($oProgramacaoContainer->programacao_container_lacres) {
            ProgramacaoContainerLacre::deleteProgramacaoContainerLacres($oProgramacaoContainer->programacao_container_lacres);
        }

        if (LgDbUtil::get('ProgramacaoContainers')->delete($oProgramacaoContainer)) {
            return $oResponse
                ->setStatus(200)
                ->setMessage('Container removido com sucesso!')
                ->setTitle('Sucesso!');
        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao remover Container!')
            ->setTitle('Ops...!');
    }

    public static function saveProgramacaoContainerFromDocumento($aRequestData, $iProgramacaoID)
    {
        $oDocumentoTransporte = LgDbUtil::getFind('DocumentosTransportes')->where(['numero' => $aRequestData['documento']])->first();
        foreach ($aRequestData['documento_containers'] as $iContainerID) {
            
            $aData = [
                'container_id'            => (int)$iContainerID,
                'documento_transporte_id' => (int)$oDocumentoTransporte->id,
                'programacao_id'                 => (int)$iProgramacaoID,
                'operacao_id'             => (int)$aRequestData['operacao_id_doc_entrada_saida'],
                'drive_espaco_id'         => (int)$aRequestData['drive_espaco_id'],
                'tipo'                    => $aRequestData['tipo_container'] 
            ];

            $oProgramacaoContainer = LgDbUtil::getFind('ProgramacaoContainers')->newEntity($aData);
            LgDbUtil::getFind('ProgramacaoContainers')->save($oProgramacaoContainer);

        }
    }

    public static function checkContainerNovo($aRequestData)
    {
        if (!$aRequestData['container_id']) {

            if (!$aRequestData['container_id'] && !$aRequestData['numero_container'])
                return false;

            if ($aRequestData['armador_id'] && $aRequestData['tipo_iso_id'])
                return true;

            return false;

        } else {

            return false;

        }
    }

    public static function verifyExistsContainerInProgramacao($iContainerID)
    {
        $oResponse = new ResponseUtil();

        if (!$iContainerID)
            return $oResponse->setStatus(200);

        $bParamValidaProgContainer = ParametroGeral::getParametroWithValue('PARAM_VALIDA_PROG_CONTAINER');

        $aWhere = [
            'Programacoes.resv_id IS' => null,
            'ProgramacaoContainers.container_id' => $iContainerID,
        ];

        if ($bParamValidaProgContainer) {
            $aWhere['Programacoes.programacao_situacao_id <>'] = EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Reprovado');
            unset($aWhere['Programacoes.resv_id IS']);
        }

        $oProgramacaoContainers = LgDbUtil::getFind('ProgramacaoContainers')
            ->select([
                'Programacoes.resv_id', 
                'ProgramacaoContainers.container_id',
                'Programacoes.id',
                'Programacoes.programacao_situacao_id'
            ])
            ->contain([
                'Programacoes' => 
                    ['Resvs' => ['OrdemServicos'], 'Vistorias']
                ])
            ->where($aWhere)
            ->toArray();

        if ($bParamValidaProgContainer) {
            foreach ($oProgramacaoContainers as $key => $oProgContainer) {
                
                $bVistoriaAberta = $bOsAberta = $bProgReprovada = false;
                if (@$oProgContainer->programacao->vistoria && !@$oProgContainer->programacao->vistoria->data_hora_fim)
                    $bVistoriaAberta = true;
    
                if (@$oProgContainer->programacao->resvs[0]->ordem_servicos[0] && !@$oProgContainer->programacao->resvs[0]->ordem_servicos[0]->data_hora_fim)
                    $bOsAberta = true;
    
                if (!$bVistoriaAberta && !$bOsAberta)
                    unset($oProgramacaoContainers[$key]);
            }
        }

        if (!$oProgramacaoContainers)
            return $oResponse->setStatus(200);

        $aProgramacoesIDs = [];
        foreach ($oProgramacaoContainers as $oProgramacaoContainer) {
            $aProgramacoesIDs[] = $oProgramacaoContainer->programacao->id;
        }
        
        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops!')
            ->setMessage('Esse Container já existe nas seguintes Programações IDs: ' . implode(", ", $aProgramacoesIDs));
    }
}
