<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DateUtil;
use App\Util\RealNumberUtil;
use App\Model\Entity\TabelasPrecosRegime;
use App\Model\Entity\TabelasPrecosTratamento;
use App\Model\Entity\TabelasPrecosTiposFaturamento;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\SaveBackUtil;
use Cake\Http\Client\Response;

/**
 * TabelasPreco Entity
 *
 * @property int $id
 * @property int $empresa_id
 * @property string $descricao
 * @property \Cake\I18n\Date $data_inicio_vigencia
 * @property \Cake\I18n\Date $data_fim_vigencia
 * @property int $ativo
 * @property float $desconto_percentual
 *
 * @property \App\Model\Entity\Empresa $empresa
 */
class TabelasPreco extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'empresa_id'=>true,
        'descricao' => true,
        'data_inicio_vigencia' => true,
        'data_fim_vigencia' => true,
        'ativo' => true,
        'desconto_percentual' => true,
        'teto_cif_de' => true,
        'teto_cif_ate' => true,
        'cif_por_kg_liquido_de' => true,
        'cif_por_kg_liquido_ate' => true,
        'tabela_preco_periodicidade_id' =>true,
        'tabelas_precos_regimes' => true,
        'tabela_preco_irregular_id' =>true,
        'empresa' => true,
        'zona_primaria' => true
    ];

    public function myRules(){
        return $this->data_fim_vigencia > $this->data_inicio_vigencia ?:__('Data de fim menor que data de inicio.');
    }

    public function getDescontoPercentual(){
        return RealNumberUtil::convertNumberToView($this->desconto_percentual, 3);
    }

    public function setDescontoPercentual($numero){
        $this->desconto_percentual = RealNumberUtil::convertNumberToDB($numero);
    }

    public function setDataInicioVigencia($data){
        $this->data_inicio_vigencia = DateUtil::dateTimeToDB($data);

    }

    public function setDataFimVigencia($data){
        $this->data_fim_vigencia = DateUtil::dateTimeToDB($data);

    }

    public function setAtivo($ativo = 1){
        $this->ativo = $ativo;
    }

    public function setEmpresaAtual($empresa_id = null){
        $this->empresa_id = $empresa_id;
    }

    public static function add($that){
        $empresa_atual = $that->getRequest()
            ->getSession()->read('empresa_atual');
        $tabelasPreco = $that->TabelasPrecos->newEntity();
        if ($that->request->is('post')) {

            $tabelasPreco = $that->TabelasPrecos
                ->patchEntity($tabelasPreco, $that->request->getData());
            $tabelasPreco->setDataInicioVigencia(
                $that->request->getData('data_inicio_vigencia'));
            $tabelasPreco->setDataFimVigencia(
                $that->request->getData('data_fim_vigencia'));
            $tabelasPreco->setAtivo();
            $tabelasPreco->setEmpresaAtual($empresa_atual);
            $tabelasPreco->setDescontoPercentual($that->request->getData('desconto_percentual'));

            $tabelasPreco->cif_por_kg_liquido_de = DoubleUtil::toDBUnformat($that->request->getData('cif_por_kg_liquido_de'));
            $tabelasPreco->cif_por_kg_liquido_ate = DoubleUtil::toDBUnformat($that->request->getData('cif_por_kg_liquido_ate'));

            $tabelasPreco->teto_cif_de = DoubleUtil::toDBUnformat($that->request->getData('teto_cif_de'));
            $tabelasPreco->teto_cif_ate = DoubleUtil::toDBUnformat($that->request->getData('teto_cif_ate'));
            
            if ($that->TabelasPrecos->save($tabelasPreco)) {
                $that->Flash->success(
                    __('Tabelas Preço') . __(' has been saved.'));
                TabelasPrecosRegime::insertManyRegimes(
                    $tabelasPreco->id, $that->request->getData('regime_id'));
                TabelasPrecosTratamento::insertManyTratamentos(
                    $tabelasPreco->id, $that->request->getData('tratamento_id'));
                TabelasPrecosTiposFaturamento::insertManyTiposFaturamento(
                    $tabelasPreco->id, $that->request->getData('tipo_faturamento_id'));
                TabelasPrecosModal::insertManyTabelasPrecosModais(
                    $tabelasPreco->id, $that->request->getData('modal_id'));
                return $that->redirect(['action' => 'edit', $tabelasPreco->id]);
            }

            $that->Flash->error(
                __('Tabelas Preço') . __(' could not be saved. Please, try again.'));
        }

        $irregulares = $that->TabelasPrecos->TabelaPrecoIrregulares
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();

        $tratamentos = $that->TratamentosCargas->find('list')->toArray();
        $regimes = $that->RegimesAduaneiros->find('list')->toArray();
        $tiposFaturamentos = $that->TiposFaturamentos->find('list')->toArray();
        $modais = LgDbUtil::get('Modais')->find('list')->toArray();
        $periodicidades = LgDbUtil::get('TabelaPrecoPeriodicidades')
            ->find('list', ['keyField' => 'id','valueField' => 'descricao'])
            ->toArray();
        $that->set(compact('tabelasPreco', 'tratamentos', 'regimes', 'tiposFaturamentos', 'modais', 'irregulares', 'periodicidades'));
    }

    public static function edit($that, $id){
        
        if ($that->request->is(['patch', 'post', 'put'])) {
            $tabelasPreco = $that->TabelasPrecos->get($id);
            $tabelasPreco = $that->TabelasPrecos->patchEntity(
                $tabelasPreco, $that->request->getData());
            $tabelasPreco->setDataInicioVigencia(
                $that->request->getData('data_inicio_vigencia'));
            $tabelasPreco->setDataFimVigencia(
                $that->request->getData('data_fim_vigencia'));
            $tabelasPreco->setDescontoPercentual($that->request->getData('desconto_percentual'));

            $tabelasPreco->cif_por_kg_liquido_de = DoubleUtil::toDBUnformat($that->request->getData('cif_por_kg_liquido_de'));
            $tabelasPreco->cif_por_kg_liquido_ate = DoubleUtil::toDBUnformat($that->request->getData('cif_por_kg_liquido_ate'));

            $tabelasPreco->teto_cif_de = DoubleUtil::toDBUnformat($that->request->getData('teto_cif_de'));
            $tabelasPreco->teto_cif_ate = DoubleUtil::toDBUnformat($that->request->getData('teto_cif_ate'));

            if ($that->TabelasPrecos->save($tabelasPreco)) {

                TabelasPrecosRegime::updateManyRegimes(
                    $tabelasPreco->id, 
                    json_decode($that->request->getData('regime_id_add')),
                    json_decode($that->request->getData('regime_id_del')),
                    $that->request->getData('regime_id'));
                TabelasPrecosTratamento::updateManyTratamentos(
                    $tabelasPreco->id, 
                    json_decode($that->request->getData('tratamento_id_add')),
                    json_decode($that->request->getData('tratamento_id_del')), $that->request
                        ->getData('tratamento_id'));
                TabelasPrecosTiposFaturamento::updateManyTiposFaturamentos(
                    $tabelasPreco->id, 
                    json_decode($that->request
                        ->getData('tipo_faturamento_id_add')),
                    json_decode($that->request
                        ->getData('tipo_faturamento_id_del')),
                    $that->request
                        ->getData('tipo_faturamento_id'));

                TabelasPrecosModal::updateManyTabelasPrecosModais(
                    $tabelasPreco->id, 
                    json_decode($that->request
                        ->getData('modal_id_add')),
                    json_decode($that->request
                        ->getData('modal_id_del')),
                    $that->request
                        ->getData('modal_id'));
        
                    $that->Flash->success(__('Tabelas Preco') . __(' has been saved.'));
                    
                return $that->redirect(['action' => 'edit', $tabelasPreco->id]);
            }
            $that->Flash->error(
                __('Tabelas Preco') . __(' could not be saved. Please, try again.'));
        }

        $tabelasPreco = $that->TabelasPrecos->get($id, [
            'contain' => [
                'TabelasPrecosRegimes', 
                'TabelasPrecosTratamentos',
                'TabelasPrecosOpcoes' => ['Empresas','TiposEmpresas'],
                'TabelasPrecosPeriodosArms'=>['TabelasPrecos','SistemaCampos', 'TiposValores'],
                'TabelasPrecosServicos' => ['TabelasPrecos','SistemaCampos', 'TiposValores', 'Servicos']]
        ]);

        $irregulares = $that->TabelasPrecos->TabelaPrecoIrregulares
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();
        $tratamentos = $that->TratamentosCargas->find('list')->toArray();
        $regimes = $that->RegimesAduaneiros->find('list')->toArray();
        $tiposFaturamentos = $that->TiposFaturamentos->find('list')->toArray();
        $modais = LgDbUtil::get('Modais')->find('list')->toArray();

        $periodicidades = LgDbUtil::get('TabelaPrecoPeriodicidades')
            ->find('list', ['keyField' => 'id','valueField' => 'descricao'])
            ->toArray();

        $tabelasPrecosTratamentos = $that->TabelasPrecosTratamentos->find('list', [
                'keyField' => 'slug',
                'valueField' => 'tratamento_id'
            ])
            ->contain(['TabelasPrecos'])
            ->where(['TabelasPrecos.id'=>$id])
            ->toArray();

        $tabelasPrecosRegimes = $that->TabelasPrecosRegimes->find('list', [
                'keyField' => 'slug',
                'valueField' => 'regime_id'
            ])
            ->contain(['TabelasPrecos'])
            ->where(['TabelasPrecos.id'=>$id])
            ->toArray();
        $tabelasPrecosTiposFaturamentos = $that->TabelasPrecosTiposFaturamentos
            ->find('list', [
                'keyField' => 'slug',
                'valueField' => 'tipo_faturamento_id'
            ])
            ->contain(['TabelasPrecos'])
            ->where(['TabelasPrecos.id'=>$id])
            ->toArray();
        $tabelasPrecosModais = $that->TabelasPrecosModais
            ->find('list', [
                'keyField' => 'descricao',
                'valueField' => 'modal_id'
            ])
            ->contain(['TabelasPrecos'])
            ->where(['TabelasPrecos.id'=>$id])
            ->toArray();
            
        $that->set(compact('tabelasPreco','tratamentos', 'regimes', 'tabelasPrecosRegimes', 'tabelasPrecosTratamentos','tiposFaturamentos', 'tabelasPrecosTiposFaturamentos', 'tabelasPrecosModais', 'modais', 'irregulares', 'periodicidades'));
    }

    public static function getTabelaPrecoByParams($oTabelasPrecos, $that, $aTratamentosIDs, $oLiberacaoDocumental)
    {

        $oRecinto = $oLiberacaoDocumental->recinto_aduaneiro;

        $iExactTabelaPrecoID = null;
        $aExtraConditions = [
            'TabelasPrecosRegimes.regime_id' => $oLiberacaoDocumental->regime_aduaneiro_id,
            'AND' => [
                $oLiberacaoDocumental->cif_por_peso_liquido . ' >= ' . 'TabelasPrecos.cif_por_kg_liquido_de AND ' .
                $oLiberacaoDocumental->cif_por_peso_liquido . ' <= ' . 'TabelasPrecos.cif_por_kg_liquido_ate',
            ],
            'OR' => [
                'TabelasPrecos.teto_cif_de IS NULL AND TabelasPrecos.teto_cif_ate IS NULL',
                'TabelasPrecos.teto_cif_de = 0 AND TabelasPrecos.teto_cif_ate = 0',
                "($oLiberacaoDocumental->resultado_moeda_cif >= TabelasPrecos.teto_cif_de AND ".
                "$oLiberacaoDocumental->resultado_moeda_cif  <= TabelasPrecos.teto_cif_ate)",
            ]
        ];

        if($oRecinto && $oRecinto->zona_secundaria == 0){
            $aExtraConditions['TabelasPrecos.zona_primaria'] = 1;
        }

        $oLiberacaoDocumentalDecisaoTabelaPreco = LgDbUtil::getFirst('LiberacaoDocumentalDecisaoTabelaPrecos', [
            'liberacao_documental_id' => $oLiberacaoDocumental->id,
            'tipo_vinculo' => 'manual'
        ]);

        $iModalId = $oLiberacaoDocumental->modal_id;
        if (!$iModalId) {
            $oLiberacaoDocumentalItem = LgDbUtil::getFind('LiberacoesDocumentaisItens')
                ->contain(['DocumentosMercadoriasLote' => ['DocumentosTransportes']])
                ->where([
                    'liberacao_documental_id' => $oLiberacaoDocumental->id
                ])
                ->first();

            $iModalId = $oLiberacaoDocumentalItem->documentos_mercadorias_lote->documentos_transporte->modal_id;
        }

        if ($oLiberacaoDocumentalDecisaoTabelaPreco) {
            $iExactTabelaPrecoID = $oLiberacaoDocumentalDecisaoTabelaPreco->tabela_preco_id;
            $aExtraConditions = [
                'TabelasPrecos.id' => $iExactTabelaPrecoID
            ];
        }

        $aTabelasPrecos = $oTabelasPrecos
            ->select($that->TabelasPrecos)
            ->select($that->RegimeAduaneiroTipoFaturamentos)
            ->select($that->TabelasPrecosRegimes)
            ->select($that->TabelasPrecosTratamentos)
            
            ->innerJoinWith('TabelasPrecosRegimes', function($q) {

                $q->innerJoinWith('RegimeAduaneiroTipoFaturamentos', function($q) {
                    return $q->where([
                        'RegimeAduaneiroTipoFaturamentos.regime_aduaneiro_id = TabelasPrecosRegimes.regime_id'
                    ]);
                });

                return $q;
            })
            ->innerJoinWith('TabelasPrecosTiposFaturamentos', function($q) {

                $q->innerJoinWith('RegimeAduaneiroTipoFaturamentos', function($q) {
                    return $q->where([
                        'RegimeAduaneiroTipoFaturamentos.tipo_faturamento_id = TabelasPrecosTiposFaturamentos.tipo_faturamento_id'
                    ]);
                });

                return $q;

            })
            ->innerJoinWith('TabelasPrecosTratamentos', function($q) use ($aTratamentosIDs, $iExactTabelaPrecoID) {
                
                if (!$iExactTabelaPrecoID)
                    $q->where([
                        'tratamento_id IN' => $aTratamentosIDs
                    ]);

                return $q;
            })
            ->innerJoinWith('TabelasPrecosModais', function($q) use ($iModalId) {
                
                return $q->where([
                    'modal_id IN' => $iModalId
                ]);
            })
            ->where([
                'RegimeAduaneiroTipoFaturamentos.tipo_faturamento_id = TabelasPrecosTiposFaturamentos.tipo_faturamento_id'
            ] + $aExtraConditions)
            ->order(['TabelasPrecos.id']);

        return $aTabelasPrecos;
    }

    public static function getTabelaPrecoByFatuAntecessor($oTabelasPrecos, $that, $oFaturamentoAntecessor)
    {
        return $oTabelasPrecos
            ->select($that->TabelasPrecos)
            ->select($that->RegimeAduaneiroTipoFaturamentos)
            ->select($that->TabelasPrecosRegimes)
            ->select($that->TabelasPrecosTratamentos)
            ->innerJoinWith('TabelasPrecosRegimes', function($q) {

                $q->innerJoinWith('RegimeAduaneiroTipoFaturamentos', function($q) {
                    return $q->where([
                        'RegimeAduaneiroTipoFaturamentos.regime_aduaneiro_id = TabelasPrecosRegimes.regime_id'
                    ]);
                });

                return $q;
            })
            ->innerJoinWith('TabelasPrecosTiposFaturamentos', function($q) {

                $q->innerJoinWith('RegimeAduaneiroTipoFaturamentos', function($q) {
                    return $q->where([
                        'RegimeAduaneiroTipoFaturamentos.tipo_faturamento_id = TabelasPrecosTiposFaturamentos.tipo_faturamento_id'
                    ]);
                });

                return $q;

            })
            ->innerJoinWith('TabelasPrecosTratamentos', function($q) {
                return $q;
            })
            ->where([
                'TabelasPrecos.id' => $oFaturamentoAntecessor->that['tabela_preco_id'],
            ])
            ->order(['TabelasPrecos.id']);
    }

    public static function duplicar($id){

        $oResponseUtil = new ResponseUtil();
        $oNewEntity = LgDbUtil::duplicateEntity('TabelasPrecos', ['id' => $id]);

        if(empty($oNewEntity)){
            return $oResponseUtil
                ->setMessage('Falha ao duplicar o Tabela Preços')
                ->setStatus(400);
        }

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosRegimes',
            'id' => 'tabela_preco_id'
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosTratamentos',
            'id' => 'tabela_preco_id'
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosTiposFaturamentos',
            'id' => 'tabela_preco_id'
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosOpcoes',
            'id' => 'tabela_preco_id'
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosPeriodosArms',
            'id' => 'tabela_preco_id',
            'children' => [
                [
                    'table' => 'TabPrecosValidaPerArms',
                    'id' => 'tab_preco_per_arm_id'
                ]
            ]
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosServicos',
            'id' => 'tabela_preco_id',
            'children' => [
                [
                    'table' => 'TabPrecosValidaServicos',
                    'id' => 'tab_preco_servico_id'
                ]
            ]
        ]);

        LgDbUtil::duplicateRelationship($id, $oNewEntity->id, [
            'table' => 'TabelasPrecosEquipesTrabalhos',
            'id' => 'tabelas_preco_id',
        ]);

        return $oResponseUtil->setStatus(200);
    }



}
