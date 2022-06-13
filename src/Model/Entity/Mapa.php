<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Mapa Entity
 *
 * @property int $id
 * @property int|null $comissario_id
 * @property int|null $agente_id
 * @property int|null $despachante_id
 * @property string|null $madeira
 * @property string|null $necessita_vistoria
 * @property int|null $vistoriado_por
 * @property \Cake\I18n\Time|null $vistoriado_em
 * @property int|null $liberado_por
 * @property \Cake\I18n\Time|null $liberado_em
 * @property string|null $comentario
 * @property int $documento_transporte_id
 * @property int $tipo_mapa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\TipoMapa $tipo_mapa
 * @property \App\Model\Entity\MapaAnexo[] $mapa_anexos
 */
class Mapa extends Entity
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
        
        'comissario_id' => true,
        'agente_id' => true,
        'despachante_id' => true,
        'madeira' => true,
        'necessita_vistoria' => true,
        'vistoriado_por' => true,
        'vistoriado_em' => true,
        'liberado_por' => true,
        'liberado_em' => true,
        'comentario' => true,
        'documento_transporte_id' => true,
        'tipo_mapa_id' => true,
        'empresa' => true,
        'documentos_transporte' => true,
        'tipo_mapa' => true,
        'mapa_anexos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function formatArrayView($aMapas)
    {
        $aMapasViews = [];
        foreach ($aMapas as $key => $oMapa) {

            $aProdutos = [];
            $aUnidadeMedidas = [];
            if (!@$oMapa->documentos_mercadoria->documentos_mercadorias_itens[0]) {

                $aDocMercadorias = LgDbUtil::getFind('DocumentosMercadorias')
                    ->contain(['DocumentosMercadoriasItens' => [
                        'Produtos',
                        'UnidadeMedidas'
                    ]])
                    ->where(['documento_mercadoria_id_master' => $oMapa->documento_mercadoria_id])
                    ->toArray();
                
                foreach ($aDocMercadorias as $oDocMercadoria) {
                    $aProdutos += array_reduce($oDocMercadoria->documentos_mercadorias_itens, function($carry, $oDocMercItem) {
                        $carry[$oDocMercItem->produto_id] = $oDocMercItem->produto->descricao;

                        return $carry;
                    }, []);

                    $aUnidadeMedidas = array_reduce($oDocMercadoria->documentos_mercadorias_itens, function($carry, $oDocMercItem) {
                        $carry[$oDocMercItem->unidade_medida_id] = $oDocMercItem->unidade_medida->descricao;

                        return $carry;
                    }, []);
                }          

            } else {
                $aProdutos[] = $oMapa->documentos_mercadoria->documentos_mercadorias_itens[0]->produto->descricao;
            }
            
            $sNecessitaVistoria = 'Pendente';
            if (isset($oMapa->necessita_vistoria) && $oMapa->necessita_vistoria)
                $sNecessitaVistoria = 'Sim';
            elseif (isset($oMapa->necessita_vistoria) && !$oMapa->necessita_vistoria)
                $sNecessitaVistoria = 'Não';
            elseif (!$oMapa->mapa_anexos)
                $sNecessitaVistoria = 'Em Digitação';

            $aContainers = array_reduce($oMapa->item_containers, function($carry, $oItemContainer) use ($oMapa) {
                if ($oMapa->container_id && $oMapa->container_id == $oItemContainer->container_id) {
                    $carry[] = $oItemContainer->container->numero;
                    return $carry;
                } else {
                    $carry[] = $oItemContainer->container->numero;
                }

                return $carry;
            }, []);

            $aSituacao = self::getSituacaoMapa($oMapa);
            $bProgReproved = self::getIfHasProgReproved($oMapa->documentos_transporte->programacao_documento_transportes);

            $aMapasViews[] = [
                'cor_mapa' => $aSituacao['cor'],
                'necessita_vistoria' => $sNecessitaVistoria,
                'produto' => implode('<br>', $aProdutos),
                'pais_origem' => $oMapa->documentos_mercadoria->pais_origem_id ? $oMapa->documentos_mercadoria->pais->descricao : '',
                'cliente' => $oMapa->documentos_mercadoria->cliente_id ? $oMapa->documentos_mercadoria->cliente->descricao : '',
                'unidade_medida' => implode('<br>', $aUnidadeMedidas),
                'container' => implode('<br>', $aContainers),
                'qtde_container' => $oMapa->container_id ? 1 : count($oMapa->documentos_transporte->container_entradas),
                'conhecimento' => $oMapa->documentos_mercadoria->numero_documento,
                'ce_mercante' => $oMapa->documentos_mercadoria->ce_mercante,
                'mapa' => $oMapa,
                'tem_doc' => $oMapa->mapa_anexos ? 1 : 0,
                'situacao' => $aSituacao['situacao'],
                'data_liberacao' => DateUtil::dateTimeFromDB($oMapa->liberado_em, 'd/m/Y H:i', ' '),
                'pode_editar' => $aSituacao['situacao'] != 'Em Digitação' ? false : true,
                'pode_agendar' => $oMapa->necessita_vistoria == 1 && !$oMapa->vistoria_itens ? true : false,
                'prog_reprovada' => $bProgReproved
            ];
        }

        return $aMapasViews;
    }

    public static function getSituacaoMapa($oMapa)
    {
        if ($oMapa->liberado_em)
            return [
                'situacao' => __('Liberado MAPA'),
                'cor' => '#41de00'
            ];

        $bAnexoBl = self::getIfHasBl($oMapa);

        if (!$oMapa->mapa_anexos || !$bAnexoBl)
            return [
                'situacao' => __('Em Digitação'),
                'cor' => '#ff8d00'
            ];

        if ($oMapa->necessita_vistoria === null)
            return [
                'situacao' => __('Aguardando MAPA'),
                'cor' => '#00aaff'
            ];

        if ($oMapa->necessita_vistoria == 1 && !$oMapa->documentos_transporte->programacao_documento_transportes)
            return [
                'situacao' => __('Selecionado para vistoria'),
                'cor' => '#ff4f4f'
            ];

        $bProgReproved = self::getIfHasProgReproved($oMapa->documentos_transporte->programacao_documento_transportes);

        if ($bProgReproved)
            return [
                'situacao' => __('Programação reprovada'),
                'cor' => '#ff4f4f'
            ];

        if (!$oMapa->vistoria_itens && $oMapa->documentos_transporte->programacao_documento_transportes)
            return [
                'situacao' => __('Aguardando confirmação do setor de vistorias'),
                'cor' => '#00aaff'
            ];

        if ($oMapa->vistoria_itens && !@$oMapa->vistoria_itens[0]->vistoria->data_hora_fim)
            return [
                'situacao' => __('Aguardando vistoria MAPA'),
                'cor' => '#00aaff'
            ];

        if ($oMapa->vistoria_itens && @$oMapa->vistoria_itens[0]->vistoria->data_hora_fim)
            return [
                'situacao' => __('Aguardando Liberação MAPA'),
                'cor' => '#ff8d00'
            ];
    }

    public static function getFilters()
    {   
        return [
            [
                'name'  => 'produto',
                'divClass' => 'col-lg-3',
                'label' => 'Produto',
                'table' => [
                    'className' => 'DocumentosMercadorias.DocumentosMercadoriasItens.Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-3',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'Clientes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'unidade_medida',
                'divClass' => 'col-lg-3',
                'label' => 'Espécie',
                'table' => [
                    'className' => 'DocumentosMercadorias.DocumentosMercadoriasItens.UnidadeMedidas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'DocumentosTransportes.ContainerEntradas.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'conhecimento',
                'divClass' => 'col-lg-2',
                'label' => 'Conhecimento',
                'table' => [
                    'className' => 'DocumentosTransportes',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'ce_mercante',
                'divClass' => 'col-lg-2',
                'label' => 'CE Mercante',
                'table' => [
                    'className' => 'DocumentosMercadorias',
                    'field'     => 'ce_mercante',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'data_criacao',
                'divClass' => 'col-lg-4',
                'label' => 'Data',
                'table' => [
                    'className' => 'Mapas',
                    'field'     => 'created_at',
                    'operacao'  => 'entre',
                    'type'      => 'date'
                ]
            ],
        ];
    }

    public static function getIfHasBl($oMapa)
    {
        $bAnexoBl = false;
        foreach ($oMapa->mapa_anexos as $oMapaAnexo) {
            if ($oMapaAnexo->mapa_anexo_tipo_id == EntityUtil::getIdByParams('MapaAnexoTipos', 'descricao', 'BL'))
                $bAnexoBl = true;
        }

        return $bAnexoBl;
    }

    public static function filtraQueryIndexMapa($iFiltro)
    {
        $aWhere = [];
        $subquery = LgDbUtil::getFind('VistoriaItens')
            ->select(['id'])
            ->where([
                'VistoriaItens.documento_transporte_id = Mapas.documento_transporte_id'
            ]);

        switch ($iFiltro) {
            case 1:
                $aWhere = ['necessita_vistoria' => 1, 'liberado_em IS NULL'];
                break;
            case 3:
                $aWhere = [
                    'AND' => [
                        'necessita_vistoria IS NULL',
                        function ($exp) use ($subquery) {
                            return $exp->notExists($subquery);
                        },
                        'liberado_por IS NULL'
                    ]
                ];
                break;
            case 4:
                $aWhere = ['necessita_vistoria' => 1, 'vistoriado_por IS NULL'];
                break;
            default:
                break;
        }

        return $aWhere;
    }

    public static function atualizaMapas($aCampos)
    {
        $aMapaIds = [];
        if ($aCampos) {
            foreach ($aCampos as $iMapaId => $campo) {
                $aMapaIds[] = $iMapaId;
            }

            $aEntityMapas = LgDbUtil::getFind('Mapas')
                ->where(['id IN' => $aMapaIds])
                ->toArray();

            $aMapaEntities = [];
            foreach ($aEntityMapas as $oMapa) {
                $aMapaEntities[] = LgDbUtil::get('Mapas')->patchEntity($oMapa, $aCampos[$oMapa->id]);
            }

            LgDbUtil::get('Mapas')->saveMany($aMapaEntities);
        }
    }

    public static function getQueryMapa($that, $isFiscal, $iFiltro)
    {
        $sContain = 'MapaAnexos';
        $aWhere = Mapa::filtraQueryIndexMapa($iFiltro);
        
        if ($isFiscal)
            $sContain = 'MapaAnexosInner';

        $aMapas = $that->Mapas->find()
            ->contain([
                'MapaProcessos',
                'VistoriaItens' => [
                    'Vistorias'
                ],
                $sContain,
                'Usuarios',
                'LiberadoPor',
                'ItemContainers' => [
                    'Containers',
                    'DocumentosMercadoriasItens' => [
                        'UnidadeMedidas',
                        'Produtos'
                    ]
                ],
                'DocumentosTransportes' => [
                    'ContainerEntradas' => [
                        'Containers'
                    ],
                    'ProgramacaoDocumentoTransportes' => [
                        'Programacoes'
                    ]
                ],
                'DocumentosMercadorias' => [
                    'Paises',
                    'Clientes',
                    'DocumentosMercadoriasItens' => [
                        'UnidadeMedidas',
                        'Produtos'
                    ]
                ],
                'TipoMapas',
                'Representantes' => [
                    'EmpresasUsuarios'
                ]
            ])
            ->where($aWhere);
            
        if ($isFiscal) {
            $aMapas = $aMapas->leftJoinWith('DocumentosMercadorias.Paises')->order([
                'Paises.descricao' => 'ASC'
            ]);
            $iMapaAnexoTipoBl = EntityUtil::getIdByParams('MapaAnexoTipos', 'descricao', 'BL');
            $aMapas = $aMapas->innerJoinWith('MapaAnexos', function ($q) use($iMapaAnexoTipoBl){
                return $q->where(['MapaAnexos.mapa_anexo_tipo_id' => $iMapaAnexoTipoBl]);
            });
        } else {
            $aMapas = $aMapas->order([
                'Mapas.id' => 'DESC'
            ]);
        }

        return $aMapas;
    }

    private static function getIfHasProgReproved($aProgramacaoContainers)
    {
        $bHasProgReproved = false;
        foreach ($aProgramacaoContainers as $oProgramacaoContainer) {
            if ($oProgramacaoContainer->programacao->programacao_situacao_id 
                == EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Reprovado')) {
                $bHasProgReproved = true;
            } else {
                $bHasProgReproved = false;
            }
        }

        return $bHasProgReproved;
    }
}
