<?php
namespace LogPluginColetores\RegraNegocio\ColetorMaritimo;

use App\Model\Entity\ParametroGeral;
use App\Model\Entity\TabelaTipoCaracteristica;
use App\RegraNegocio\PlanejamentoMaritimo\LingadasManager;
use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\LoginUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use App\Util\UniversalCodigoUtil;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use DateTime;
use stdClass;

class ColetorMaritimoManager 
{

    private $oPlanejamentoMaritimosTable;

    public function __construct()
    {
        $this->oPlanejamentoMaritimosTable = TableRegistry::getTableLocator()->get('PlanejamentoMaritimos');
    } 

    public static function getResv($sPlate){
        return TableRegistry::getTableLocator()->get('Resvs')
            ->find()
            ->contain(['Veiculos', 'Transportadoras', 'OrdemServicoItemLingadas'])
            ->where([
                'Veiculos.veiculo_identificacao' => $sPlate,
                'Resvs.data_hora_saida is' => null
            ])
            ->max('id');
    }

    public static function getResvById($ResvID){
        return TableRegistry::getTableLocator()->get('Resvs')
            ->find()
            ->contain([
                'Veiculos', 
                'Transportadoras', 
                'OrdemServicoItemLingadas'
            ])
            ->where(['Resvs.id' => $ResvID])
            ->first();
    }

    public function getAvailableShips(){
        $aShips = array();
        $iUsuarioID = SessionUtil::getUsuarioConectado();
        $iOrdemServicoTiposId = EntityUtil::getIdByParams(
            'OrdemServicoTipos', 'descricao', 'Operação Marítima');
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        
        $aPlanejamentos = $this->oPlanejamentoMaritimosTable
            ->find()
            ->contain([
                'PlanejamentoMaritimoTernos' => ['PlanejamentoMaritimoTernoUsuarios', 'PlanejamentoMaritimoTernoPeriodos'],
                'SituacaoProgramacaoMaritimas', 
                'Veiculos',
                'Sentidos',
                'ResvPlanejamentoMaritimos' => [
                    'Resvs' => 'OrdemServicos'
                ]
            ])
            ->where([
                'SituacaoProgramacaoMaritimas.codigo' => 'EFETIVADO',
                'PlanejamentoMaritimos.versao' => function ($exp, $q)  {
                    return $exp->add(
                        '(SELECT MAX(pm.versao) 
                            FROM planejamento_maritimos pm
                           WHERE pm.numero = PlanejamentoMaritimos.numero
                             AND pm.viagem_numero = PlanejamentoMaritimos.viagem_numero )'
                    );
                }
            ])

            ->matching('ResvPlanejamentoMaritimos.Resvs', function ($q) use($iOrdemServicoTiposId) {
                return $q
                    ->where(['data_hora_saida is' => null])
                    ->matching('OrdemServicos' , function ($q) use($iOrdemServicoTiposId){
                        return $q->where([
                            'data_hora_fim is' => null, 
                            'ordem_servico_tipo_id' => $iOrdemServicoTiposId,
                            'ordem_servico_tipo_id IS NOT' => null
                        ]);
                    });
            })

            ->matching('PlanejamentoMaritimoTernos.PlanejamentoMaritimoTernoUsuarios', 
                function ($q) use($iUsuarioID) {
                return $q->where(['PlanejamentoMaritimoTernoUsuarios.usuario_id' => $iUsuarioID]);
            })
            ->matching('PlanejamentoMaritimoTernos.PlanejamentoMaritimoTernoPeriodos', 
                function ($q) use($oPeriodoAtual) {
                return $q->where([
                    'PlanejamentoMaritimoTernoPeriodos.periodo_id' => $oPeriodoAtual->id,
                    'PlanejamentoMaritimoTernoPeriodos.data_periodo' => DateUtil::dateTimeFromDB($oPeriodoAtual->inicio, 'Y-m-d'),
                ]);
            })
            ->toarray();

        foreach ($aPlanejamentos as $key => $value) {
            $aShips[$value->id]  = $value;
        }
        return  $aShips;
    }

    public function getAvailableShipsById($sId){

        $iOrdemServicoTiposId = EntityUtil::getIdByParams(
            'OrdemServicoTipos', 'descricao', 'Operação Marítima');
        
        return  $this->oPlanejamentoMaritimosTable
            ->find()
            ->contain([
                'Veiculos',
                'SituacaoProgramacaoMaritimas', 
                'ResvPlanejamentoMaritimos' => [
                    'Resvs' => 'OrdemServicos'
                ],
                'OperacaoPortuarias'
            ])
            ->where([
                'PlanejamentoMaritimos.id' => $sId,
                'SituacaoProgramacaoMaritimas.codigo' => 'EFETIVADO',
                'PlanejamentoMaritimos.versao' => function ($exp, $q)  {
                    return $exp->add(
                        '(SELECT MAX(pm.versao) 
                            FROM planejamento_maritimos pm
                           WHERE pm.numero = PlanejamentoMaritimos.numero
                             AND pm.viagem_numero = PlanejamentoMaritimos.viagem_numero )'
                    );
                }
            ])

            ->matching('ResvPlanejamentoMaritimos.Resvs', function ($q) use($iOrdemServicoTiposId) {
                return $q
                    ->where(['data_hora_saida is' => null])
                    ->matching('OrdemServicos' , function ($q) use($iOrdemServicoTiposId){
                        return $q->where([
                            'data_hora_fim is' => null, 
                            'ordem_servico_tipo_id' => $iOrdemServicoTiposId,
                            'ordem_servico_tipo_id IS NOT' => null
                        ]);
                    });
            })->first();
            
    }

    public function getPlanOfCargoByPlanning($sId){

        $aResult = $this->oPlanejamentoMaritimosTable
            ->PlanoCargas
            ->find()
            ->contain([
                'PlanoCargaTipoMercadorias',
                'PlanoCargaDocumentos' => 'OperadorPortuarios'
            ])
            ->where([
                'PlanoCargas.planejamento_maritimo_id' => $sId,
            ])
            ->toArray();

        return $aResult;
    }

    public function getPoroesByPlanOfCargo($oPlanoCarga){

        $oPlanoCarga->poroes = LgDbUtil::get('Poroes')
            ->find()
            ->contain([
                'PlanoCargaPoroes' => function ($q) use($oPlanoCarga){
                    return $q
                        ->contain([
                            'Produtos',
                            'PlanoCargaPoraoCaracteristicas' => [
                                'Caracteristicas',
                                'TipoCaracteristicas'
                            ]
                        ])
                        ->where([
                            'PlanoCargaPoroes.cancelado' => 0,
                            'PlanoCargaPoroes.plano_carga_id' => $oPlanoCarga->id
                        ]);
                }
            ])
            ->matching('PlanoCargaPoroes', function ($q) use($oPlanoCarga){
                return $q
                    ->where([
                        'PlanoCargaPoroes.cancelado' => 0,
                        'PlanoCargaPoroes.plano_carga_id' => $oPlanoCarga->id
                    ]);
                }
            )
            ->distinct(['Poroes.id'])   
            ->toArray(); 

        return $oPlanoCarga;
    }

    public function doTabelaCaracteriscas($oPlanoCarga){

        if(empty($oPlanoCarga->plano_carga_caracteristicas)){
            return $oPlanoCarga;
        }
        
        foreach ($oPlanoCarga->plano_carga_caracteristicas as $value) {
            if(isset($value->tabela_tipo_caracteristica)){
                $value->tabela_tipo_caracteristica = $this->getTabelaValor($value->tabela_tipo_caracteristica);
            }
        }

        return $oPlanoCarga;
    }

    private function getTabelaValor($oTipoCaracteristica){
        $oTipoCaracteristica->descricao = '';

        try {

            if(empty($oTipoCaracteristica->tabela) || empty($oTipoCaracteristica->coluna) || empty($oTipoCaracteristica->valor)){
                return $oTipoCaracteristica;
            }
            
            $oObject = LgDbUtil::get(@$oTipoCaracteristica->tabela)
                ->find()
                ->where(['id' => @$oTipoCaracteristica->valor])
                ->first();

            $oTipoCaracteristica->descricao = $oObject[$oTipoCaracteristica->coluna];
            return $oTipoCaracteristica;
        } catch (\Throwable $th) {
            return $oTipoCaracteristica;
        }

        return $oTipoCaracteristica; 
    }

    public function getLingadaRemocoesByPlanejemento($planejamento_maritimo_id){

        return TableRegistry::getTableLocator()
        ->get('LingadaRemocoes')
        ->find()
        ->contain(['Remocoes', 'OrdemServicoItemLingadas' => [
            'Resvs' => 'Veiculos',
            'PlanoCargaPoroes' => 
            'PlanoCargas',
        ]])
        ->where([
            'PlanoCargas.planejamento_maritimo_id' => $planejamento_maritimo_id
        ])
        ->toArray();
    }

    public function getParalisacoesByPlanejamento($planejamento_maritimo_id){
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        $oQuery = TableRegistry::getTableLocator()->get('Paralisacoes')
        ->find()
        ->contain(['ParalisacaoMotivos', 'Poroes'])
        ->where([
            'planejamento_maritimo_id' => $planejamento_maritimo_id,
            'data_hora_inicio >=' => $oPeriodoAtual->inicio,
            'data_hora_fim <' => $oPeriodoAtual->fim
        ]);

        if(SessionUtil::getPerfilUsuario() == 1){
            return $oQuery->toArray();
        }

        return $oQuery->where([
            'created_by' => SessionUtil::getUsuarioConectado()
        ])->toArray();
        
    }

    public function getDirections(){
        return $this->oPlanejamentoMaritimosTable->Sentidos->find('list');
    }

    public function getTernos(){
        return ['' => 'Selecione']+TableRegistry::getTableLocator()->get('Ternos')->find('list',['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
    }

    public function getRemocoes(){
        return ['' => 'Selecione']+TableRegistry::getTableLocator()->get('Remocoes')->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
    }

    public function getAvarias(){
        return ['' => 'Selecione']+TableRegistry::getTableLocator()->get('Avarias')->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
    }

    public function getParalisacaoMotivos(){
        return ['' => 'Selecione']+TableRegistry::getTableLocator()->get('ParalisacaoMotivos')->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
    }

    public function getPoroes(){
        return ['' => 'Selecione']+TableRegistry::getTableLocator()->get('Poroes')->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
    }

    
    public function verifyPlate($sPlate){
        $oResponseUtil = new ResponseUtil();
        $oResult= self::getResv($sPlate);
        if(isset($oResult)){
            return $oResponseUtil
            ->setDataExtra([
                'iResv' => $oResult->id, 
                'oResv' => $oResult
            ])
            ->setMessage('Ok, veículo com resv aberta.')
            ->setStatus(200);
        }
        $oEmpresa = LgDbUtil::getByID('Empresas', 1);
        return $oResponseUtil->setMessage("Placa: $sPlate, não está no $oEmpresa->descricao. Confira novamente a placa, caso o erro permaneça entre em contato com o setor de Operações.");
    }

    public function addParalisacao($aData){
        $oResponseUtil = new ResponseUtil(); 
        $aData['created_by'] = SessionUtil::getUsuarioConectado(); 

        if(empty($aData['notificacao'])){
            $aData['data_hora_inicio'] = DateUtil::dateTimeToDB(
                $aData['data_hora_inicio'], 'd-m-Y H:i');
            $aData['data_hora_fim'] = DateUtil::dateTimeToDB(
                $aData['data_hora_fim'], 'd-m-Y H:i');
            if ($aData['data_hora_inicio'] > $aData['data_hora_fim']) {
                $aData['data_hora_fim'] = DateUtil::addMoreOneDay($aData['data_hora_fim']);
            }
        }else{
            $aData['data_hora_inicio'] = $this->getDateTimeParalisacao(
                $aData['planejamento_maritimo_id']);
            $aData['data_hora_fim'] = DateUtil::defautDatetime();
        }

        if(!empty($aData['lingada_id'])){
            $oLingada = LgDbUtil::getFirst('OrdemServicoItemLingadas', [
                'id' => $aData['lingada_id']
            ]);
            $aData['plano_carga_porao_id'] = @$oLingada->plano_carga_porao_id;
        }

        if(empty($aData['operador_portuario_id'])){
            $oPm = LgDbUtil::getFirst('PlanejamentoMaritimos', [
                'id' =>  @$aData['planejamento_maritimo_id']
            ]);
            $aData['operador_portuario_id'] = @$oPm->oper_portuaria_id;
        }

        $sHoraInicio = DateUtil::dateTimeFromDB($aData['data_hora_inicio'], 'H:i:s');
        $sHoraFim = DateUtil::dateTimeFromDB($aData['data_hora_fim'], 'H:i:s');

        $aPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();

        if($sHoraInicio > $sHoraFim && $aPeriodoAtual->codigo != '19-01') {
            return $oResponseUtil
            ->setMessage('A hora inicio não pode ser maior que a hora fim.');
        }

        $oAssociacaoTerno = LgDbUtil::getFind('AssociacaoTernos')
        ->innerJoinWith('PlanejamentoMaritimoTernos')
        ->where([
            'AssociacaoTernos.porao_id' => $aData['porao_id'],
            'AssociacaoTernos.periodo_id' => @$aPeriodoAtual->id,
            'PlanejamentoMaritimoTernos.planejamento_maritimo_id' => @$aData['planejamento_maritimo_id']
        ])
        ->orderDesc('AssociacaoTernos.id')
        ->first();
        
        if(!$oAssociacaoTerno) {
            return $oResponseUtil
            ->setMessage('Solicite ao setor de Operações para associar sua turma ao porão.');
        }

        $aData['terno_id'] = @$oAssociacaoTerno->terno_id;
        $aData['periodo_id'] = @$aPeriodoAtual->id;

        $oParalisacaoDB = LgDbUtil::getFind('Paralisacoes')
        ->where([
            'terno_id'                 => @$aData['terno_id'],
            'periodo_id'               => @$aData['periodo_id'],
            'porao_id'                 => @$aData['porao_id'],
            'planejamento_maritimo_id' => @$aData['planejamento_maritimo_id'],
            'OR' => [
                [
                    'data_hora_inicio >=' => $aData['data_hora_inicio'],
                    'data_hora_inicio <' => $aData['data_hora_fim'],
                ],
                [
                    'data_hora_fim >' => $aData['data_hora_inicio'], 
                    'data_hora_fim <=' => $aData['data_hora_fim']
                ]
            ],
         ])
        ->first();
          
        if($oParalisacaoDB) {
            return $oResponseUtil
            ->setMessage('Já existe uma paralisação cadastrada para esse horário.');
        }

        if(LgDbUtil::saveNew('Paralisacoes', $aData, true)){
            $iTempo = $this->getTimestampParalisacao(
                $aData['planejamento_maritimo_id']
            );

            $aParalisacoes = $this->getParalisacoesByPlanejamento(
                $aData['planejamento_maritimo_id']
            );

            return $oResponseUtil->setStatus(200)
                ->setDataExtra([
                    'iTempoParalisacao' => $iTempo,
                    'aParalisacoes' => $aParalisacoes
                ])
                ->setMessage('Paralisação salva com sucesso.');
        }

        return $oResponseUtil
            ->setMessage('Falha ao salvar a paralisação, por favor tente novamente.');
    }

    public function editParalisacao($id,  $aData){

        $oResponseUtil = new ResponseUtil();        

        $oEntity = LgDbUtil::getFirst('Paralisacoes', ['id' => $id]);

        $aData['data_hora_inicio'] = DateUtil::dateTimeToDB(
            $aData['data_hora_inicio'], 'd-m-Y H:i');
        $aData['data_hora_fim'] = DateUtil::dateTimeToDB(
            $aData['data_hora_fim'], 'd-m-Y H:i');
        
        if ($aData['data_hora_inicio'] > $aData['data_hora_fim']) {
            $aData['data_hora_fim'] = DateUtil::addMoreOneDay($aData['data_hora_fim']);
        }

        $oEntity = LgDbUtil::get('Paralisacoes')
            ->patchEntity($oEntity, $aData);
                       
        if(LgDbUtil::save('Paralisacoes', $oEntity)){
            $iTempo = $this->getTimestampParalisacao(
                $oEntity->planejamento_maritimo_id
            );

            $aParalisacoes = $this->getParalisacoesByPlanejamento(
                $oEntity->planejamento_maritimo_id
            );

            return $oResponseUtil
                ->setStatus(200)
                ->setDataExtra([
                    'iTempoParalisacao' => $iTempo,
                    'aParalisacoes' => $aParalisacoes
                ])
                ->setMessage('Paralisão salvar com sucesso.');
        }

        return $oResponseUtil
            ->setMessage('Falha ao salvar a paralisação, por favor tente novamente.');
    }

    public function deleteParalisacao($id){

        $oResponseUtil = new ResponseUtil();        

        $oEntity = LgDbUtil::getFirst('Paralisacoes', ['id' => $id]);
        $iPlanejamento = $oEntity->planejamento_maritimo_id;
                       
        if(LgDbUtil::get('Paralisacoes')->delete($oEntity)){
            $iTempo = $this->getTimestampParalisacao(
                $iPlanejamento
            );

            $aParalisacoes = $this->getParalisacoesByPlanejamento(
                $iPlanejamento
            );

            return $oResponseUtil
                ->setStatus(200)
                ->setDataExtra([
                    'iTempoParalisacao' => $iTempo,
                    'aParalisacoes' => $aParalisacoes
                ])
                ->setMessage('Paralisão deletada com sucesso.');
        }

        return $oResponseUtil
            ->setMessage('Falha ao deletar a paralisação, por favor tente novamente.');
    }

    public function getDateTimeParalisacao($planejamento_id){

        $oParameter = ParametroGeral::getParameterByUniqueName('TEMPO_MAX_OCIOSO_COLETOR_MARITIMO');

        if(empty($oParameter)){
            return null;
        }

        $oLastParelisacoes = LgDbUtil::getFirst('Paralisacoes', [
            'planejamento_maritimo_id' => $planejamento_id], ['data_hora_fim' => 'DESC']);

        $dData =  @$oLastParelisacoes->data_hora_fim;

        $oLingada =  LgDbUtil::getFind('OrdemServicoItemLingadas')
            ->contain(['PlanoCargaPoroes' => 'PlanoCargas'])
            ->matching('PlanoCargaPoroes.PlanoCargas', function($query) use($planejamento_id){
                return $query->where(['PlanoCargas.planejamento_maritimo_id' => $planejamento_id]);
            })
            ->order(['OrdemServicoItemLingadas.created_at' => 'DESC'])
            ->select(['OrdemServicoItemLingadas.created_at'])
            ->first();

        // if(isset($oLingada)){
        //     $oLingada->created_at->modify("-3 hours");
        // }

        $dData = $this->getBiggerTime($dData, @$oLingada->created_at);

        if(isset($dData)){
            $dData->modify("+$oParameter->valor minutes");
        }

        return $dData;
    
    }

    public function getTimestampParalisacao($planejamento_id){
        $dData = $this->getDateTimeParalisacao($planejamento_id);
        return @$dData ? $dData->toUnixString() : 0 ;
    }


    public function getBiggerTime($oTime, $oTimeTwo){

        if(empty($oTimeTwo)){
            return $oTime;
        }

        if(empty($oTime)){
            return $oTimeTwo;
        }

        if($oTime > $oTimeTwo){
            return $oTime;
        }

        return $oTimeTwo;
    }

    public function getPlanoCargaPoroes($aData){

        if(!$aData['documentacao_obrigatoria']){

            return LgDbUtil::getFind('PlanoCargaPoroes')
                ->contain(['PlanoCargaPackingLists', 'OrdemServicoItemLingadas'])
                ->where([
                    'PlanoCargaPackingLists.produto_codigo' => $aData['codigo'],
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                    'cancelado' => 0
                ])
                ->order('qtde_prevista')
                ->toArray();

        }

        $oQuery = LgDbUtil::getFind('PlanoCargaPoroes')
            ->contain([
                'OrdemServicoItemLingadas',
                'DocumentosMercadoriasItens' =>[
                    'Produtos' => function ($q) use($aData){
                        return $q->where([
                           'Produtos.id' => $aData['produto_id']
                        ]);
                    },
                    'DocumentosMercadorias.PlanoCargaDocumentos'=> function ($q) use($aData){
                        return $q->where([
                            'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                            'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                        ]);
                    }
                ]
            ])
            ->matching('DocumentosMercadoriasItens.Produtos', function ($q) use($aData){
                return $q->where([
                   'Produtos.id' => $aData['produto_id']
                ]);
            })
            ->matching('DocumentosMercadoriasItens.DocumentosMercadorias.PlanoCargaDocumentos', 
                function ($q) use($aData){
                return $q->where([
                    'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                ]);
            });

            if($aData['cliente_obrigatorio']){
                $oQuery->matching('DocumentosMercadoriasItens.DocumentosMercadorias', function ($q) use($aData){
                    return $q->where(['DocumentosMercadorias.cliente_id' => $aData['cliente_id']]);
                });
            }

            $aResult = $oQuery->where([
                'plano_carga_id' => $aData['plano_carga_id'], 
                'cancelado' => 0,
                'porao_id' => $aData['porao_id'],
            ])
            ->order('qtde_prevista')
            ->toArray(); 

            return $aResult;
    }

    public function getPlanoCargaPorao($aData){

        if(!$aData['documentacao_obrigatoria']){

            return LgDbUtil::getFind('PlanoCargaPoroes')
                ->contain(['PlanoCargaPackingLists', 'OrdemServicoItemLingadas'])
                ->where([
                    'PlanoCargaPackingLists.produto_codigo' => $aData['codigo'],
                    'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
                    'cancelado' => 0
                ])
                ->order('qtde_prevista')
                ->first();

        }

        $oQuery =  LgDbUtil::getFind('PlanoCargaPoroes')
            ->contain([
                'OrdemServicoItemLingadas',
                'DocumentosMercadoriasItens' =>[
                    'Produtos' => function ($q) use($aData){
                        return $q->where([
                           'Produtos.id' => $aData['produto_id']
                        ]);
                    },
                    'DocumentosMercadorias.PlanoCargaDocumentos'=> function ($q) use($aData){
                        return $q->where([
                            'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                            'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                        ]);
                    }
                ]
            ])
            ->matching('DocumentosMercadoriasItens.Produtos', function ($q) use($aData){
                return $q->where([
                   'Produtos.id' => $aData['produto_id']
                ]);
            })
            ->matching('DocumentosMercadoriasItens.DocumentosMercadorias.PlanoCargaDocumentos', 
                function ($q) use($aData){
                return $q->where([
                    'PlanoCargaDocumentos.plano_carga_id' => $aData['plano_carga_id'],
                    'PlanoCargaDocumentos.operador_portuario_id' => $aData['operador_portuario_id']
                ]);
            });

            if($aData['cliente_obrigatorio']){
                $oQuery->matching('DocumentosMercadoriasItens.DocumentosMercadorias', function ($q) use($aData){
                    return $q->where(['DocumentosMercadorias.cliente_id' => $aData['cliente_id']]);
                });
            }

            return $oQuery->where([
                'PlanoCargaPoroes.plano_carga_id' => $aData['plano_carga_id'], 
                'PlanoCargaPoroes.cancelado' => 0,
                'PlanoCargaPoroes.porao_id' => $aData['porao_id'],
            ])
            ->order('qtde_prevista')
            ->first(); 
    }

    public function findPlanoCarga($aData, $iPorao_id = null, $bValidaUser = false){
        $oResponse = new ResponseUtil();
        $bObrigatorio = $this->bObrigadoDocumentacao($aData['planejamento_id']);
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();

        $oPlanoCarga =  $this->oPlanejamentoMaritimosTable
            ->PlanoCargas
            ->find()
            ->contain([
                'AssociacaoTernos' => function ($q) use ($oPeriodoAtual) {
                    return $q
                    ->contain(['Ternos', 'Poroes', 'PortoTrabalhoPeriodos'])
                    ->where([
                        'AssociacaoTernos.created_at >=' => $oPeriodoAtual->inicio,
                        'AssociacaoTernos.created_at <' => $oPeriodoAtual->fim,
                        'AssociacaoTernos.periodo_id' => $oPeriodoAtual->id
                    ]);
                },
                'PlanoCargaPoroes' =>  function ($q)  {
                    return $q
                    ->contain([
                        'PlanoCargaPackingLists',
                        'OrdemServicoItemLingadas' => [
                            'Ternos',
                            'PlanoCargaPoroes' => [
                                'Poroes'
                            ],
                            'Resvs' => [
                                'Veiculos'
                            ], 
                            'LingadaAvarias' => [
                                'Avarias', 
                                'LingadaAvariaFotos'
                            ]
                        ],
                        'LingadaRemocoes' => [
                            'Remocoes',
                            'Produtos',
                            'PlanoCargaPoroes' => [
                                'Poroes'
                            ],  
                        ]
                    ])
                    ->where([
                        'PlanoCargaPoroes.cancelado' => 0
                    ]);
                },
                'Sentidos',
                'PlanoCargaCaracteristicas' => [
                    'Caracteristicas' => 'TipoCaracteristicas', 
                    'TabelaTipoCaracteristicas' => 'TipoCaracteristicas'
                ],
                'PlanoCargaDocumentos',
                'PlanoCargaTipoMercadorias',
                'PlanoCargaPoraoCondicoes'
            ]);

            if($bObrigatorio){
                $oPlanoCarga->matching('PlanoCargaDocumentos', function($q) use($aData){
                    return $q->where(['operador_portuario_id' => $aData['operador_portuario_id']]);
                });
            }

            $oPlanoCarga = $oPlanoCarga->where([
                'PlanoCargas.planejamento_maritimo_id' => $aData['planejamento_id'],
                'PlanoCargas.tipo_mercadoria_id' => $aData['plano_carga_mercadoria_id']
            ])
            ->first(); 

            if(empty($oPlanoCarga)){
                return $oResponse->setMessage('Falha ao Localizar Plano Carga');
            }

            $oPlanoCarga = $this->getPoroesByPlanOfCargo($oPlanoCarga);
            $oPlanoCarga = $this->doTabelaCaracteriscas($oPlanoCarga);
            $iTempoParalisacao = $this->getTimestampParalisacao($aData['planejamento_id']);

            if ($bValidaUser) {
                $oPlanoCarga = self::getOnlyLingadasTernoUser($oPlanoCarga->id, $oPlanoCarga);
            }


            return $oResponse->setStatus(200)->setDataExtra([
                'oPlanoCarga' => $oPlanoCarga,
                'iTempoParalisacao' => $iTempoParalisacao
            ]);
            
    }

    public function getPlanoCarga($id, $iPorao_id = null, $bValidaUser = false){
        $aExtraWhere = [];

        if ($iPorao_id) {
            $aExtraWhere = ['PlanoCargaPoroes.porao_id is' => $iPorao_id];
        }
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        $oPlanoCarga =  $this->oPlanejamentoMaritimosTable
            ->PlanoCargas
            ->find()
            ->contain([
                'AssociacaoTernos' => function ($q) use ($oPeriodoAtual) {
                    return $q
                    ->contain(['Ternos', 'Poroes', 'PortoTrabalhoPeriodos'])
                    ->where([
                        'AssociacaoTernos.created_at >=' => $oPeriodoAtual->inicio,
                        'AssociacaoTernos.created_at <' => $oPeriodoAtual->fim,
                        'AssociacaoTernos.periodo_id' => $oPeriodoAtual->id
                    ]);
                },
                'PlanoCargaPoroes' =>  function ($q) use ($aExtraWhere) {
                    return $q
                    ->contain([
                        'PlanoCargaPackingLists',
                        'Poroes',
                        'OrdemServicoItemLingadas' => [
                            'Ternos' ,
                            'PlanoCargaPoroes' => [
                                'Poroes'
                            ],
                            'Resvs' => [
                                'Veiculos'
                            ], 
                            'LingadaAvarias' => [
                                'Avarias', 
                                'LingadaAvariaFotos'
                            ],
                        ],
                        'LingadaRemocoes' => [
                            'Remocoes',
                            'Produtos',
                            'PlanoCargaPoroes' => [
                                'Poroes'
                            ],      
                        ]
                    ])
                    ->where([
                        'PlanoCargaPoroes.cancelado' => 0
                    ] +  $aExtraWhere);
                },
                'Sentidos',
                'PlanoCargaCaracteristicas' => [
                    'Caracteristicas' => 'TipoCaracteristicas', 
                    'TabelaTipoCaracteristicas' => 'TipoCaracteristicas'
                ],
                'PlanoCargaDocumentos',
                'PlanoCargaTipoMercadorias',
                'PlanoCargaPoraoCondicoes'
            ])
            ->where(['PlanoCargas.id' => $id])
            ->first();

        // && SessionUtil::getUsuarioConectado() != 1
        if ($bValidaUser) {
            $oPlanoCarga = self::getOnlyLingadasTernoUser($id, $oPlanoCarga);
        }

        $oPlanoCarga = $this->getPoroesByPlanOfCargo($oPlanoCarga);
        $oPlanoCarga = $this->doTabelaCaracteriscas($oPlanoCarga);
        $oPlanoCarga = $this->getSaldoPoroes($oPlanoCarga);

        return $oPlanoCarga;
    }

    /**
     * Captura somente as lingadas que tem o "terno" deste "user" neste "planejamento maritimo", e 
     * somente as lingadas que tiverem o mesmo periodo da last() lingada
     */
    private static function getOnlyLingadasTernoUser($iPlanoCargaID, $oPlanoCarga)
    {
        $oPlanoCargaEntity = LgDbUtil::getByID('PlanoCargas', $iPlanoCargaID);
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        $aPlanejamentoMaritimoTernoUsuario = LgDbUtil::getFind('PlanejamentoMaritimoTernoUsuarios')
            ->contain(['PlanejamentoMaritimoTernos'])
            ->where([
                'PlanejamentoMaritimoTernoUsuarios.usuario_id' => SessionUtil::getUsuarioConectado(),
                'PlanejamentoMaritimoTernos.planejamento_maritimo_id' => $oPlanoCargaEntity->planejamento_maritimo_id
            ])
            ->toArray();

        $oLingadaLast = new stdClass;

        foreach ($oPlanoCarga->plano_carga_poroes as $iKeyPlanoCargaPorao => $oPlanoCargaPorao) {
            foreach ($oPlanoCargaPorao->ordem_servico_item_lingadas as $iKeyOrdemServicoLingadas => $oOrdemServicoLingada) {
                $oLingadaLast = @$oLingadaLast->id < $oOrdemServicoLingada->id
                    ? $oOrdemServicoLingada
                    : $oLingadaLast;
            }
        }

        $iLastPeriodoID = $oLingadaLast 
            ? @$oLingadaLast->periodo_id
            : null;
        
        $aTernoIDs = [];

        foreach ($aPlanejamentoMaritimoTernoUsuario as $oPlanejamentoMaritimoTernoUsuario) {
            $aTernoIDs[$oPlanejamentoMaritimoTernoUsuario->planejamento_maritimo_terno->terno_id] = true;
        }

        if (!$aTernoIDs || !$oPlanoCarga) 
            return $oPlanoCarga;

        foreach ($oPlanoCarga->plano_carga_poroes as $iKeyPlanoCargaPorao => $oPlanoCargaPorao) {
            $aOrdemServicoLingadas = [];

            foreach ($oPlanoCargaPorao->ordem_servico_item_lingadas as $iKeyOrdemServicoLingadas => $oOrdemServicoLingada) {


                if ($oPeriodoAtual) {

                    if (@$aTernoIDs[$oOrdemServicoLingada->terno_id] 
                    && $oOrdemServicoLingada->periodo_id == $oPeriodoAtual->id
                    && DateUtil::dateTimeFromDB($oOrdemServicoLingada->created_at, 'Y-m-d') == DateUtil::dateTimeFromDB($oPeriodoAtual->inicio, 'Y-m-d')) {
                        $aOrdemServicoLingadas[] = $oOrdemServicoLingada;
                    }

                }elseif (@$aTernoIDs[$oOrdemServicoLingada->terno_id]) {
                    $aOrdemServicoLingadas[] = $oOrdemServicoLingada;
                }
            }

            $oPlanoCargaPorao->ordem_servico_item_lingadas = $aOrdemServicoLingadas;
        }

        return $oPlanoCarga;
    }

    private function bObrigadoDocumentacao($iPlanejamentoMaritimoId, $oPlanejamentoMaritimo = null){

        if(empty($oPlanejamentoMaritimo)){
            $oPlanejamentoMaritimo = LgDbUtil::getFind('PlanejamentoMaritimos')
                ->contain(['TiposViagens'])
                ->where(['PlanejamentoMaritimos.id' => $iPlanejamentoMaritimoId])
                ->first();
        }

        return empty($oPlanejamentoMaritimo->tipos_viagem) ? 1 : 
            $oPlanejamentoMaritimo->tipos_viagem->documentacao_obrigatoria;

    }

    public function getPlanejementoTernos($iPlanejamentoMaritimoId){

        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();

        $aPlanejamentoMaritimoTernos = LgDbUtil::getFind('PlanejamentoMaritimoTernos')
        ->innerJoinWith('Ternos')
        ->innerJoinWith('PlanejamentoMaritimoTernoUsuarios')
        ->innerJoinWith('PlanejamentoMaritimoTernoPeriodos.PortoTrabalhoPeriodos')
        ->where([
                'PlanejamentoMaritimoTernos.planejamento_maritimo_id' => $iPlanejamentoMaritimoId,
                'PlanejamentoMaritimoTernoUsuarios.usuario_id' => SessionUtil::getUsuarioConectado(),
                'PlanejamentoMaritimoTernoPeriodos.periodo_id' => $oPeriodoAtual->id,
                'PlanejamentoMaritimoTernoPeriodos.data_periodo' => DateUtil::dateTimeFromDB($oPeriodoAtual->inicio, 'Y-m-d')
        ])
        ->toArray();
        $aData = [];
        foreach ($aPlanejamentoMaritimoTernos as $key => $planejamentoMaritimoTerno) {
            $aData[$key]['id'] = $planejamentoMaritimoTerno->terno_id;
            $aData[$key]['descricao'] = LgDbUtil::getByID('Ternos', $planejamentoMaritimoTerno->terno_id)->descricao;
            $aData[$key]['planejamento_maritimo_terno_id'] = $planejamentoMaritimoTerno->id;
        }
        return $aData;
    }

    public static function getTernoAssociado($iPm){
        $oPeriodoAtual = UniversalCodigoUtil::getPortoTrabalhoPeriodoAtual();
        $oAssociacaoTerno = LgDbUtil::getFind('PlanejamentoMaritimoTernos')
        ->innerJoinWith('PlanejamentoMaritimoTernoUsuarios')
        ->innerJoinWith('PlanejamentoMaritimoTernoPeriodos')
        ->where([
            'planejamento_maritimo_id'=> $iPm,
            'usuario_id'   => SessionUtil::getUsuarioConectado(),
            'periodo_id'   => $oPeriodoAtual->id,
            'data_periodo' => DateUtil::dateTimeFromDB($oPeriodoAtual->inicio, 'Y-m-d')
        ])
        ->first();

        return $oAssociacaoTerno;
    }

    public static function getSaldoPoroes($oPlanoCarga){
        $planoCargaPoroes =  LgDbUtil::getFind('PlanoCargaPoroes')
            ->group([
                'PlanoCargaPoroes.porao_id',
                'PlanoCargaPoroes.produto_id',
            ])
            ->contain([
                'Poroes',
                'Produtos',
            ])
            ->where([
                'PlanoCargaPoroes.plano_carga_id' => $oPlanoCarga->id,
                'PlanoCargaPoroes.cancelado' => 0
            ])
            ->select([
                'porao' =>'Poroes.id',
                'porao_descricao' =>'Poroes.descricao',
                'produto' => 'Produtos.descricao',
                'qtde_prevista' =>'SUM(PlanoCargaPoroes.qtde_prevista)',
                'peso_previsto' =>'SUM(PlanoCargaPoroes.tonelagem)'
            ])
            ->select([
                'qtde_realizada' => LgDbUtil::getFind('OrdemServicoItemLingadas')
                    ->newExpr(
                        "SELECT sum(os.qtde) 
                            from ordem_servico_item_lingadas os 
                            join plano_carga_poroes pc 
                                on os.plano_carga_porao_id = pc.id
                            where 
                            pc.plano_carga_id = PlanoCargaPoroes.plano_carga_id
                            and os.produto_id = PlanoCargaPoroes.produto_id
                            and pc.cliente_id = PlanoCargaPoroes.cliente_id
                            and pc.porao_id   = PlanoCargaPoroes.porao_id
                            and (
                                (
                                    pc.destino = PlanoCargaPoroes.destino
                                ) 
                                OR
                                (
                                    pc.destino IS NULL AND
                                    PlanoCargaPoroes.destino IS NULL
                                )
                            )
                            and pc.recebedor  = PlanoCargaPoroes.recebedor
                            and pc.cancelado  = 0
                        "
                    )
            ])
            ->select([
                'peso_realizado' => LgDbUtil::getFind('OrdemServicoItemLingadas')
                    ->newExpr(
                        "SELECT sum(os.peso) 
                            from ordem_servico_item_lingadas os 
                            join plano_carga_poroes pc 
                                on os.plano_carga_porao_id = pc.id
                            where 
                            pc.plano_carga_id = PlanoCargaPoroes.plano_carga_id
                            and os.produto_id = PlanoCargaPoroes.produto_id
                            and pc.cliente_id = PlanoCargaPoroes.cliente_id
                            and pc.porao_id   = PlanoCargaPoroes.porao_id
                            and (
                                (
                                    pc.destino = PlanoCargaPoroes.destino
                                ) 
                                OR
                                (
                                    pc.destino IS NULL AND
                                    PlanoCargaPoroes.destino IS NULL
                                )
                            )
                            and pc.recebedor  = PlanoCargaPoroes.recebedor
                            and pc.cancelado  = 0
                        "
                    )
            ])
            ->order([
                'porao', 
            ])
            ->toArray();

        $oPlanoCarga->saldo_poroes = [];

        foreach ($planoCargaPoroes as $planoCargaPorao){
            if (empty($oPlanoCarga->saldo_poroes[$planoCargaPorao->porao])) {
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao] = [
                    'porao' => $planoCargaPorao->porao,
                    'porao_descricao' => $planoCargaPorao->porao_descricao,
                    'qtde_prevista' => $planoCargaPorao->qtde_prevista,
                    'peso_previsto' => DoubleUtil::format($planoCargaPorao->peso_previsto, 3, '.', ''),
                    'qtde_realizada' => $planoCargaPorao->qtde_realizada,
                    'peso_realizado' => DoubleUtil::format($planoCargaPorao->peso_realizado, 3, '.', ''),
                    'saldo_qtde' => $planoCargaPorao->qtde_prevista - $planoCargaPorao->qtde_realizada,
                    'saldo_peso' => DoubleUtil::format($planoCargaPorao->peso_previsto - $planoCargaPorao->peso_realizado, 3, '.', '')
                ];
            } else {
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['qtde_prevista'] += $planoCargaPorao->qtde_prevista;
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['peso_previsto'] += DoubleUtil::format($planoCargaPorao->peso_previsto, 3, '.', '');
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['qtde_realizada'] += $planoCargaPorao->qtde_realizada;
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['peso_realizado'] += DoubleUtil::format($planoCargaPorao->peso_realizado, 3, '.', '');
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['saldo_qtde'] += $planoCargaPorao->qtde_prevista - $planoCargaPorao->qtde_realizada;
                $oPlanoCarga->saldo_poroes[$planoCargaPorao->porao]['saldo_peso'] += DoubleUtil::format($planoCargaPorao->peso_previsto - $planoCargaPorao->peso_realizado, 3, '.', '');
            }
        }
        return $oPlanoCarga;
    }

}