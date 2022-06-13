<?php
namespace App\Model\Entity;

use App\RegraNegocio\Container\LiberacaoAutomaticaContainer;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * ResvsContainer Entity
 *
 * @property int $id
 * @property int $container_id
 * @property int|null $documento_transporte_id
 * @property int $resv_id
 * @property int $operacao_id
 * @property int|null $cliente_id
 * @property int|null $liberacao_documental_id
 * @property int $booking_id
 * @property int $documento_genericos_id
 * @property string $tipo
 *
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\Operacao $operacao
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\DocumentoGenerico $documento_generico
 */
class ResvsContainer extends Entity
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
     /* Default fields
        
        'container_id' => true,
        'documento_transporte_id' => true,
        'resv_id' => true,
        'operacao_id' => true,
        'cliente_id' => true,
        'liberacao_documental_id' => true,
        'booking_id' => true,
        'documento_genericos_id' => true,
        'tipo' => true,
        'container' => true,
        'documentos_transporte' => true,
        'resv' => true,
        'operacao' => true,
        'empresa' => true,
        'liberacoes_documental' => true,
        'booking' => true,
        'documento_generico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveResvContainer($that)
    {
        $oResponse = new ResponseUtil();
        $aRequestData = $that->request->data();

        LiberacaoAutomaticaContainer::do(@$aRequestData['container_id']);

        $bContainerNovo = self::checkContainerNovo($aRequestData);
        if ($bContainerNovo) {
            $aRequestData['container_id'] = Container::saveContainerResv($aRequestData);
            if (!$aRequestData['container_id']) {
                return $oResponse
                    ->setStatus(400)
                    ->setMessage('Erro ao cadastrar um novo container VAZIO')
                    ->setTitle('Ops...!');
            }
        }

        $bExisteContainer = EntradaSaidaContainer::verifyIfContainerInEstoque(@$aRequestData['container_id'] ?: null, $aRequestData['operacao_id']);
        if ($bExisteContainer)
            return (new ResponseUtil())
                ->setMessage('Container já esta em estoque.');

        $oReturn = self::verifyAddContainerResvCarga($aRequestData);
        if ($oReturn->getStatus() == 400)
            return $oReturn;

        $aRequestData['liberacao_documental_id'] = null;
        if ($oReturn->getStatus() == 200) {
            $aLiberacaoDocumentais = $oReturn->getDataExtra();

            foreach ($aLiberacaoDocumentais as $oLiberacaoDocumental) {
                $aRequestData['liberacao_documental_id'] = $oLiberacaoDocumental->id;
                $aRequestData['empresa_id']              = $oLiberacaoDocumental->cliente_id;
                $oResvLiberacaoDocumental = LgDbUtil::getFind('ResvsLiberacoesDocumentais')
                    ->where([
                        'resv_id' => $aRequestData['resv_id'],
                        'liberacao_documental_id' => $oLiberacaoDocumental->id
                    ])
                    ->first();
    
                if (!$oResvLiberacaoDocumental)
                    LgDbUtil::saveNew('ResvsLiberacoesDocumentais', [
                        'resv_id' => $aRequestData['resv_id'],
                        'liberacao_documental_id' => $oLiberacaoDocumental->id
                    ]);
            }
        }

        $iOperacaoDescargaID = EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga');
        $oResponseDocs = new ResponseUtil();
        if ($aRequestData['operacao_id'] == $iOperacaoDescargaID && $aRequestData['tipo_container'] == 'CHEIO') {

            $iClienteID = self::getClienteIdByDocumentoMercadoria($aRequestData['container_id'], $aRequestData['operacao_id']);
            $aRequestData['empresa_id'] = $iClienteID;

            $oResponseDocs = self::saveResvDocumentoTransporteByContainer($aRequestData);
            if ($oResponseDocs->getStatus() != 200)
                return $oResponseDocs;

        }

        $aData = [
            'id'                      => @$aRequestData['id'],
            'container_id'            => $aRequestData['container_id'],
            'documento_transporte_id' => $aRequestData['documento_transporte_id'],
            'resv_id'                 => $aRequestData['resv_id'],
            'operacao_id'             => $aRequestData['operacao_id'],
            'cliente_id'              => @$aRequestData['empresa_id'],
            'liberacao_documental_id' => $aRequestData['liberacao_documental_id'],
            'drive_espaco_id'         => $aRequestData['drive_espaco_id'],
            // 'documento_genericos_id'  => $aRequestData['documento_genericos_id'],
            'tipo'                    => $aRequestData['tipo_container'],
            'container_forma_uso_id'  => $aRequestData['container_forma_uso_id'],
            'super_testado'           => $aRequestData['super_testado'],
            'container_destino_id'    => @$aRequestData['container_destino_id'],
            'beneficiario_id'         => $aRequestData['beneficiario_id']
        ];

        $aDataLacres = [
            'lacres_json' => $aRequestData['lacres_json']
        ];

        if (array_key_exists('quantidade_vazios', $aRequestData) 
            && $aRequestData['quantidade_vazios'] > 1 
            && !@$aData['id'] 
            && !$aRequestData['container_id'] 
            && $aRequestData['operacao_id'] != $iOperacaoDescargaID) {

                $oResponse = ProgramacaoContainer::saveContainersVazios($that, 'ResvsContainers', $aData, $aDataLacres, $aRequestData['quantidade_vazios']);
                return $oResponse;
                
        }

        $oEntityResvContainer = TableRegistry::getTableLocator()->get('ResvsContainers');

        $that->loadModel('ResvsContainers');
        $entidadeResvContainer = $that->setEntity('ResvsContainers', $aData);

        $entidadeResvContainer = $oEntityResvContainer->patchEntity($entidadeResvContainer, $aData);
        if ($oEntityResvContainer->save($entidadeResvContainer)) {

            ResvContainerLacre::saveResvContainerLacres($that, $aDataLacres, $entidadeResvContainer->id, $oResponseDocs->getDataExtra());
            if (@$aRequestData['armador_id'])
                Container::setArmadorByContainer($aRequestData['container_id'], $aRequestData['armador_id']);

            return $oResponse
                ->setStatus(200)
                ->setMessage('Container salvo na RESV com sucesso!')
                ->setTitle('Sucesso!');
        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao salvar container a RESV!')
            ->setTitle('Ops...!');
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

    public static function saveResvDocumentoTransporteByContainer($aRequestData) 
    {
        $oResponse = new ResponseUtil();

        $aDocsTransportesIDsInsert = self::getDocumentosTransportesByResvsContainers($aRequestData);
        if (!$aDocsTransportesIDsInsert)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops...!')
                ->setMessage('Parece que este Container não tem Documento de Transporte!');

        foreach ($aDocsTransportesIDsInsert as $key => $value) {

            $oDocumentosMercadoria = new DocumentosMercadoria();
            $oDocumentosMercadoria->generateLoteCodigo(null, $value);
            
            $aDataInsert = [
                'resv_id'                 => $aRequestData['resv_id'],
                'documento_transporte_id' => $value,
            ];

            $oResvDocumentoTransporte = LgDbUtil::getFirst('ResvsDocumentosTransportes', $aDataInsert);
            if (!$oResvDocumentoTransporte)
                LgDbUtil::saveNew('ResvsDocumentosTransportes', $aDataInsert);

        }

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aDocsTransportesIDsInsert);
    }

    public static function getDocumentosTransportesByResvsContainers($aRequestData)
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

    public static function deleteResvContainer($iResvContainerID)
    {
        $oResponse = new ResponseUtil();

        $entityResvsContainers = TableRegistry::getTableLocator()->get('ResvsContainers');

        $oResvContainer = $entityResvsContainers->find()->where(['id' => $iResvContainerID])->contain(['ResvContainerLacres'])->first();
        if ($oResvContainer->resv_container_lacres) {
            ResvContainerLacre::deleteResvContainerLacres($oResvContainer->resv_container_lacres);
        }

        if ($entityResvsContainers->delete($oResvContainer)) {
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

    public static function saveResvContainerFromDocumento($aRequestData, $iResvID)
    {
        switch ($aRequestData['operacao_id_doc_entrada_saida']) {
            case 1:
                $aDataDoc['table'] = 'DocumentosTransportes';
                $aDataDoc['column'] = 'documento_transporte_id';
                $iDocumentoId = $aRequestData['documento'];
                break;
            case 2:
                $aDataDoc['table'] = 'LiberacoesDocumentais';
                $aDataDoc['column'] = 'liberacao_documental_id';
                $iDocumentoId = explode('_', $aRequestData['documento'])[1];
                break;
            case EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Direta Documento'):
                $aDataDoc['table'] = 'DocumentosTransportes';
                $aDataDoc['column'] = 'documento_transporte_id';
                $iDocumentoId = $aRequestData['documento'];
                break;
            case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova - Canal Vermelho (via Doc.)')):
                $aDataDoc['table'] = 'DocumentosTransportes';
                $aDataDoc['column'] = 'documento_transporte_id';
                $iDocumentoId = $aRequestData['documento'];
                break;
            case (EntityUtil::getIdByParams('Operacoes', 'descricao', 'Desova Investigativa (Via Doc.)')):
                $aDataDoc['table'] = 'DocumentosTransportes';
                $aDataDoc['column'] = 'documento_transporte_id';
                $iDocumentoId = $aRequestData['documento'];
                break;
            

            default:
                break;
        }

        $oDocumento = LgDbUtil::getFind($aDataDoc['table'])
            ->where([$aDataDoc['table'] . '.id' => $iDocumentoId])
            ->first();

        if ($aDataDoc['table'] == 'DocumentosTransportes') {
            $oDocumentoMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
                ->where([
                    'documento_transporte_id'               => $oDocumento->id,
                    'documento_mercadoria_id_master IS NOT' => null
                ])
                ->first();

            $iClienteID = $oDocumentoMercadoria->cliente_id;
        } else if ($aDataDoc['table'] == 'LiberacoesDocumentais') {
            $iClienteID = $oDocumento->cliente_id;
        }

        $entityResvsContainers = TableRegistry::getTableLocator()->get('ResvsContainers');
        foreach ($aRequestData['documento_containers'] as $iContainerID) {

            $bExisteContainer = EntradaSaidaContainer::verifyIfContainerInEstoque(@$iContainerID ?: null, (int) $aRequestData['operacao_id_doc_entrada_saida']);
            
            if ($bExisteContainer)
                return (new ResponseUtil())
                    ->setMessage('Container já esta em estoque.');

            LiberacaoAutomaticaContainer::do($iContainerID);
            
            $aData = [
                'container_id'            => (int)$iContainerID,
                'resv_id'                 => (int)$iResvID,
                'operacao_id'             => (int)$aRequestData['operacao_id_doc_entrada_saida'],
                'tipo'                    => $aRequestData['tipo_container'],
                'cliente_id'              => $iClienteID 
            ];

            if ((int)$aRequestData['drive_espaco_id'])
                $aData['drive_espaco_id'] = (int)$aRequestData['drive_espaco_id'];

            $aData[$aDataDoc['column']] = $oDocumento->id;

            $oResvContainer = $entityResvsContainers->newEntity($aData);

            if ($entityResvsContainers->save($oResvContainer)) {
                
                if ($aDataDoc['column'] == 'documento_transporte_id') {
                    $aDocumentoLacres = LgDbUtil::getFind('Lacres')
                        ->where([
                            'documento_transporte_id' => $oDocumento->id,
                            'container_id' => $iContainerID
                        ])
                        ->toArray();

                    if ($aDocumentoLacres) {
                        foreach ($aDocumentoLacres as $oLacre) {
                            
                            $oLacreEntity = LgDbUtil::get('ResvContainerLacres')->newEntity([
                                'lacre_numero' => $oLacre->descricao,
                                'lacre_tipo_id' => $oLacre->lacre_tipo_id,
                                'resv_container_id' => $oResvContainer->id
                            ]);
            
                            LgDbUtil::get('ResvContainerLacres')->save($oLacreEntity);
                        }
                    }
                }

                $aResvContainerIds[] = $oResvContainer->id;
            }

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

    public static function getOSPendentesCarga($iOSID)
    {
        $oResvsContainers = TableRegistry::get('ResvsContainers')->find();

        $oResvsContainersIDs__custom = $oResvsContainers->newExpr()
            ->add(
                LgDbUtil::setConcatGroupByDb('Containers.numero')
            );

        $oIDsLD__custom = $oResvsContainers->newExpr()
            ->add(
                LgDbUtil::setConcatGroupByDb('Containers.numero')
            );

        $oSituacoes__custom = $oResvsContainers->newExpr()
            ->addCase(
                [
                    $oResvsContainers->newExpr()->add(
                        '(data_hora_fim IS NULL)'
                    )
                ],
                ['aguardando_carga', 'finalizado'],
                ['string', 'string']
            );

        $oSubQuery = LgDbUtil::getFind('EntradaSaidaContainers')
            ->select('super_testado')
            ->where([
                'EntradaSaidaContainers.container_id = Containers.id',
                'EntradaSaidaContainers.resv_entrada_id IS NOT NULL',
                'EntradaSaidaContainers.resv_saida_id IS NULL',
            ])->limit(1)->sql();

        $oResvsContainers = $oResvsContainers
            ->select([
                'OrdemServicos.id',
                'veiculo_identificacao' => 'Veiculos.veiculo_identificacao',
                'num_doc'               => 'ResvsContainers.id',
                'documentos_numeros'    => $oResvsContainersIDs__custom,
                'ids_registry_cnt'      => $oIDsLD__custom,
                'situacao'              => $oSituacoes__custom,
                'class_name'            => "'Resvs Containers Vazios'",
                'Resvs.id'
            ])
            ->contain([
                'Resvs' => [
                    'ResvsContainers' => [
                       'Containers' => function($q) use ($oSubQuery){
                           return $q
                           ->select(LgDbUtil::get('Containers'))
                           ->select(['super_testado' => LgDbUtil::getFind('Containers')->newExpr()->add($oSubQuery)])
                           ->contain(['Armadores']);
                       },
                     'EntradaSaidaContainers' => function($q){
                            return $q
                            ->where([
                                'EntradaSaidaContainers.resv_saida_id = ResvsContainers.resv_id',
                                'EntradaSaidaContainers.container_id = ResvsContainers.container_id'
                            ])
                            ->contain([
                                'DriveEspacosAtual' =>[
                                    'ContainerFormaUsos',
                                    'TipoIsos', 
                                    'Empresas'
                                ]
                            ])
                            ->order([
                                'EntradaSaidaContainers.id' => 'DESC'
                            ]);
                        }    
                   ]
                ],
                'Resvs.Veiculos',
                'OrdemServicos',
                'Containers'
            ])
            ->where([
                'OrdemServicos.ordem_servico_tipo_id = 2',
                'OrdemServicos.data_hora_fim IS NULL',
                'OrdemServicos.resv_id IS NOT NULL',
                "tipo = 'VAZIO'",
                'ResvsContainers.operacao_id' =>  EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga')
            ] +
                ($iOSID 
                    ? ['OrdemServicos.id' => $iOSID]
                    : [] 
                ) 
            )
            ->group([
                'OrdemServicos.id', 
                'Veiculos.veiculo_identificacao',
                'ResvsContainers.id',
                'Containers.numero',
                'OrdemServicos.data_hora_fim',
                'Resvs.id'
            ])
            ->toArray();

        if ($oResvsContainers && (!$oResvsContainers[0]['documentos_numeros'] && !$oResvsContainers[0]['ids_registry_cnt'])) {
            $oResvsContainers[0]['documentos_numeros'] = 'SEM CONTAINER';
            $oResvsContainers[0]['ids_registry_cnt'] = 'SEM CONTAINER';
        }

        return $oResvsContainers;
    }

    public static function verifyAddContainerResvCarga($aData)
    {
        if ($aData['operacao_id'] != 2)
            return (new ResponseUtil())
                ->setStatus(204)
                ->setMessage('Tipo de operação diferente de carga!');

        if ($aData['tipo_container'] != 'CHEIO')
            return (new ResponseUtil())
                ->setStatus(204)
                ->setMessage('Tipo de container diferente de CHEIO!');

        /*if (!$aData['documento_transporte_id'])
            return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage('Necessário informar o documento de transporte do container!');*/
    
        // $oDocEntradaContainer = LgDbUtil::getFind('ContainerEntradas')
        //     ->contain([
        //         'DocumentosTransportes' => [
        //             'DocumentosMercadoriasMany' => [
        //                 'DocumentosMercadoriasItens'
        //             ]
        //         ],
        //         'Containers'
        //     ])
        //     ->where([
        //         'ContainerEntradas.documento_transporte_id' => $aData['documento_transporte_id'],
        //         'ContainerEntradas.container_id' => $aData['container_id']
        //     ])
        //     ->first();
        
        // if (!$oDocEntradaContainer)
        //     return (new ResponseUtil())
        //         ->setStatus(400)
        //         ->setMessage('Este container não possuí estoque!');
        
        // $aLoteCodigos = array_reduce($oDocEntradaContainer->documentos_transporte->documentos_mercadorias, function($carry, $oDocMercadoria) {
        //     $carry[] = $oDocMercadoria->lote_codigo;
        //     return $carry;
        // });

        $oEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
            ->where(['container_id' => $aData['container_id']])
            ->toArray();

        if (!$oEstoqueEnderecos)
            return (new ResponseUtil())
                ->setStatus(400)
                ->setMessage('Este container não possuí estoque!');

        $aLoteCodigos = array_reduce($oEstoqueEnderecos, function($carry, $oEstoque) {
            $carry[] = $oEstoque->lote_codigo;
            return $carry;
        });

        $aLoteCodigos = $aLoteCodigos ?: [];

        $oLiberacaoDocumentalItens = [];
        if ($aLoteCodigos)
            $oLiberacaoDocumentalItens = LgDbUtil::getFind('LiberacoesDocumentaisItens')
                ->contain(['LiberacoesDocumentais'])
                ->where([
                    'LiberacoesDocumentaisItens.lote_codigo IN' => $aLoteCodigos,
                    'LiberacoesDocumentaisItens.container_id' => $aData['container_id']
                ])
                ->order(['LiberacoesDocumentaisItens.id' => 'DESC'])
                ->toArray();

        if (!$oLiberacaoDocumentalItens)
            return (new ResponseUtil())
                ->setMessage('Não foi encontrado liberação documental para este container!');

        if (count($oLiberacaoDocumentalItens) != count($oEstoqueEnderecos))
            return (new ResponseUtil())
                ->setMessage('O container selecionado não esta com todas as liberações documentais geradas, favor gerar!');

        $aEstoqueEnderecos  = LgDbUtil::getFind('EstoqueEnderecos')
            ->where(['EstoqueEnderecos.lote_codigo IN' => $aLoteCodigos])
            ->toArray();

        if (!$aEstoqueEnderecos)
            return (new ResponseUtil())
                ->setMessage('Container não encontrado em estoque.');

        $aLiberacaoDocumentais = array_reduce($oLiberacaoDocumentalItens, function($carry, $oLiberacaoDocumentalItem) {
            $carry[$oLiberacaoDocumentalItem->liberacoes_documental->id] = $oLiberacaoDocumentalItem->liberacoes_documental;
            return $carry;
        }, []);
        
        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Liberação documental encontrada.')
            ->setDataExtra($aLiberacaoDocumentais);
    }
    
    public static function saveContainerFromCarga($iContainerID, $iResvID)
    {
        $oResponse = new ResponseUtil();

        $oResv = LgDbUtil::getFind('Resvs')
            ->contain(['ResvsContainers'])
            ->where(['id' => $iResvID])
            ->first();

        if (!$oResv)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops...!')
                ->setMessage('Não foi possível identificar a RESV de origem da Ordem de Serviço!');

        $aConditions            = EntradaSaidaContainer::getConditionsByContainerId($iContainerID);
        $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions);

        if (!$oEntradaSaidaContainer)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops...!')
                ->setMessage('Parece que esse container não está no estoque!');

        if ($oEntradaSaidaContainer->tipo != 'VAZIO')
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops...!')
                ->setMessage('Parece que esse container está CHEIO no estoque. Selecione um VAZIO!');
            
        $iNecessidadeReparo = EntityUtil::getIdByParams('SituacaoContainers', 'descricao', 'Necessidade de Reparo');
        if ($oEntradaSaidaContainer->situacao_container_id == $iNecessidadeReparo)
            return $oResponse
                ->setStatus(403)
                ->setTitle('Ops...!')
                ->setMessage('O container está com situação de (Necessidade de Reparo), portanto não pode ser carregado.');

        if (!$oResv->resvs_containers)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops...!')
                ->setMessage('Parece que não tem nenhum registro aguardando vinculação do container nessa RESV!');

        foreach ($oResv->resvs_containers as $oResvContainer) {
            
            if (!$oResvContainer->container_id) {

                $oResvContainerEntity         = LgDbUtil::get('ResvsContainers');
                $oResvContainer->container_id = $iContainerID;
            
                if ($oResvContainerEntity->save($oResvContainer))
                    return $oResponse
                        ->setStatus(200)
                        ->setTitle('Sucesso!')
                        ->setMessage('Container salvo com sucesso!');
                        
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops...!')
                    ->setMessage('Ocorreu algum erro ao salvar o container!');
            }

        }
        
        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops...!')
            ->setMessage('Parece que não tem nenhum registro aguardando vinculação do container nessa RESV!');
    }

    public static function getPesagemResvContainers($iResvID)
    {
        $aResvContainers = LgDbUtil::getFind('ResvsContainers')
        ->contain([
            'Containers',
            'Operacoes'
        ])
        ->where(['ResvsContainers.resv_id' => $iResvID])
        ->toArray();
        return $aResvContainers;
    }

}
