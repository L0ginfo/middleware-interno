<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * OrdemServicoServexec Entity
 *
 * @property int $id
 * @property float $quantidade
 * @property \Cake\I18n\Time $data_hora_inicio
 * @property \Cake\I18n\Time $data_hora_fim
 * @property int $ordem_servico_id
 * @property int $servico_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Servico $servico
 * @property \App\Model\Entity\Empresa $empresa
 */
class OrdemServicoServexec extends Entity
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
        'quantidade' => true,
        'data_hora_inicio' => true,
        'data_hora_fim' => true,
        'ordem_servico_id' => true,
        'servico_id' => true,
        'empresa_id' => true,
        'ordem_servico' => true,
        'servico' => true,
        'empresa' => true,
        'container_id' => true,
        'observacao' => true
    ];

    public static function getServexecsByLiberacaoDocumental( $that, $oLiberacaoDocumental )
    {

        $oLiberacoesDocumentaisItens = $that->LiberacoesDocumentaisItens->find()
            ->contain([
                'Estoques' => [
                    'EtiquetaProdutos' => [
                        'DocumentosMercadoriasItens' => [
                            'DocumentosMercadorias' => [
                                'OrdemServicos' => function ( $q ) {
                                    return $q
                                        ->contain([
                                            'OrdemServicoServexecs' => function ($q) {
                                                return $q
                                                    ->contain([
                                                        'Servicos'
                                                    ])
                                                    ->where([
                                                    'data_hora_fim IS NOT NULL'
                                                ]);
                                            }
                                        ])
                                        ->where([
                                            'data_hora_fim IS NOT NULL',
                                            'cancelada = 0'
                                        ]);
                                }
                            ]
                        ]
                    ]
                ]
            ])
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id' => $oLiberacaoDocumental->id
            ])
            ->toArray();

        $aServexecIDsValidos = array();
        $oServexecsValidos = array();
        $aDocMercIDs = array();
        foreach ($oLiberacoesDocumentaisItens as $key => $oItens) {
            $aEtiquetas = $oItens->estoque->etiqueta_produtos;

            foreach ($aEtiquetas as $key => $aEtiqueta) {

                $oOSs = $aEtiqueta->documentos_mercadorias_item->documentos_mercadoria->ordem_servicos;

                foreach ($oOSs as $key => $oOS) {
                    if (!isset($oOS->ordem_servico_servexecs))
                        continue;
                    
                    $oOSServexecs = $oOS->ordem_servico_servexecs;
                    if ($oOSs && $oOSServexecs) 
                        foreach ($oOSServexecs as $key => $oOSServexec) 
                            if (!in_array($oOSServexec->id, $aServexecIDsValidos)){
                                $aServexecIDsValidos[] = $oOSServexec->id;
                                $oServexecsValidos[] = $oOSServexec;
                                $aDocMercIDs[] = $aEtiqueta->documentos_mercadorias_item->documentos_mercadoria->id;
                            }
                }
            }
        }
        
        return [
            'ids'  => $aServexecIDsValidos,
            'objs' => $oServexecsValidos,
            'doc_mercs' => $aDocMercIDs
        ];
    }

    public static function getServexecsByHouse($iHouseId)
    {

        $aDocumentosMercadorias = LgDbUtil::get('DocumentosMercadorias')->find()
            ->contain([
                'OrdemServicos' => function ( $q ) {
                    return $q
                        ->contain([
                            'OrdemServicoServexecs' => function ($q) {
                                return $q
                                    ->contain([
                                        'Servicos'
                                    ])
                                    ->where([
                                        // 'data_hora_fim IS NOT NULL'
                                    ]);
                            }
                        ])
                        ->where([
                            // 'data_hora_fim IS NOT NULL',
                            'cancelada = 0'
                        ]);
                }
            ])
            ->where([
                'DocumentosMercadorias.id' => $iHouseId
            ])
            ->toArray();

        $aServexecIDsValidos = array();
        $oServexecsValidos = array();
        $aDocMercIDs = array();
        foreach ($aDocumentosMercadorias as $key => $oDoc) {
            $oOSs = $oDoc->ordem_servicos;

            foreach ($oOSs as $key => $oOS) {
                if (!isset($oOS->ordem_servico_servexecs)) continue;
                
                if ($oOSs && $oOS->ordem_servico_servexecs) {
                    $oOSServexecs = $oOS->ordem_servico_servexecs;
                    foreach ($oOSServexecs as $key => $oOSServexec) {
                        if (!in_array($oOSServexec->id, $aServexecIDsValidos)){
                            $aServexecIDsValidos[] = $oOSServexec->id;
                            $oServexecsValidos[] = $oOSServexec;
                            $aDocMercIDs[] = $oDoc->id;
                        }
                    }
                }
            }
            
        }
        
        return [
            'ids'  => $aServexecIDsValidos,
            'objs' => $oServexecsValidos,
            'doc_mercs' => $aDocMercIDs
        ];
    }

    public static function addServicoContainer($aData)
    {
        $oResponse = new ResponseUtil();

        unset($aData['adicionar_servico_container']);
        $aData['data_hora_inicio'] = DateUtil::dateTimeToDB($aData['data_hora_inicio']);
        $aData['data_hora_fim']    = DateUtil::dateTimeToDB($aData['data_hora_fim']);
        $aData['empresa_id']       = Empresa::getEmpresaPadrao();

        if (!LgDbUtil::saveNew('OrdemServicoServexecs', $aData))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao adicionar o serviço!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Serviço adicionado com sucesso!');
    }

    public static function getServicosContainers($oOrdemServico)
    {
        $oServicosContainers = LgDbUtil::getFind('OrdemServicoServexecs')
            ->contain(['Servicos', 'Containers'])
            ->where(['ordem_servico_id' => $oOrdemServico->id])
            ->toArray();

        if (!$oServicosContainers)
            return null;

        $aServicosContainers = [];
        foreach ($oServicosContainers as $oServicoContainer) {
            
            $aServicosContainers[$oServicoContainer->container->numero][] = [
                'id'               => $oServicoContainer->id,
                'servico'          => $oServicoContainer->servico->descricao,
                'data_hora_inicio' => DateUtil::dateTimeFromDB($oServicoContainer->data_hora_inicio, 'd/m/Y H:i', ' '),
                'data_hora_fim'    => DateUtil::dateTimeFromDB($oServicoContainer->data_hora_fim, 'd/m/Y H:i', ' '),
                'quantidade'       => $oServicoContainer->quantidade,
                'observacao'       => $oServicoContainer->observacao,
            ];

        }

        return $aServicosContainers;
    }

    public static function deleteServicoContainer($aData)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServicoServexecEntity = LgDbUtil::get('OrdemServicoServexecs');
        $oOrdemServicoServexec       = LgDbUtil::getFirst('OrdemServicoServexecs', ['id' => $aData['ordem_servico_servexec_id']]);

        if (!$oOrdemServicoServexec)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Serviço não encontrado!');

        if (!$oOrdemServicoServexecEntity->delete($oOrdemServicoServexec))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao remover o serviço!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Serviço removido com sucesso!');
    }
}
