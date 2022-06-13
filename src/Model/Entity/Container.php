<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Container Entity
 *
 * @property int $id
 * @property string|null $numero
 * @property string|null $capacidade_m3
 * @property string|null $mes_ano_fabricacao
 * @property float|null $tara
 * @property float|null $payload
 * @property float|null $temp_minima
 * @property float|null $temp_maxima
 * @property int $armador_id
 * @property int $tipo_iso_id
 *
 * @property \App\Model\Entity\Lote $lote
 * @property \App\Model\Entity\IsoCode $iso_code
 * @property \App\Model\Entity\ItemAgendamento[] $item_agendamentos
 * @property \App\Model\Entity\Item[] $itens
 * @property \App\Model\Entity\Consolidado[] $consolidados
 * @property \App\Model\Entity\Entrada[] $entradas
 */
class Container extends Entity
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
        
        'numero' => true,
        'capacidade_m3' => true,
        'mes_ano_fabricacao' => true,
        'tara' => true,
        'payload' => true,
        'temp_minima' => true,
        'temp_maxima' => true,
        'armador_id' => true,
        'tipo_iso_id' => true,
        'lote' => true,
        'iso_code' => true,
        'item_agendamentos' => true,
        'itens' => true,
        'consolidados' => true,
        'entradas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'numero',
                'divClass' => 'col-lg-3',
                'label' => 'Número',
                'table' => [
                    'className' => 'Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'armador',
                'divClass' => 'col-lg-3',
                'label' => 'Armador',
                'table' => [
                    'className' => 'Containers.Empresas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'tipo_isos',
                'divClass' => 'col-lg-3',
                'label' => 'Tipo Iso',
                'table' => [
                    'className' => 'Containers.TipoIsos',
                    'field'     => 'sigla',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function checkContainerLogBox ($sContainer) 
    {
        $oResponse = new ResponseUtil();

        $sNumeroContainerExists = trim(str_replace(
            ['-', ' '],
            ['', ''],
            $sContainer
        ));

        $oContainer = TableRegistry::getTableLocator()->get('Containers')->find()
            ->contain(['TipoIsos' => ['ContainerTamanhos']])
            ->select([
                'container_id_edit'       => 'Containers.id',
                'numero_container_edit'   => 'Containers.numero',
                'armador_container_edit'  => 'Containers.armador_id',
                'tipo_iso_container_edit' => 'TipoIsos.id',
                'tara_container_edit'     => 'Containers.tara',
            ])
            ->where(['numero' => $sNumeroContainerExists])
            ->first();

        if (!$oContainer)
            return $oResponse
                ->setStatus(400)
                ->setMessage('O container ' . $sContainer . ' não existe no sistema. Deseja cadastrar?')
                ->setTitle('Ops...');

        return $oResponse
            ->setStatus(200)
            ->setMessage('Container encontrado com sucesso!')
            ->setTitle('Sucesso!')
            ->setDataExtra($oContainer);
    }

    public static function setContainerLogBox ($aDataInputs)
    {
        $sNumeroContainerExists = trim(str_replace(
            ['-', ' '],
            ['', ''],
            $aDataInputs['numero_container_edit']
        ));

        $oResponse = new ResponseUtil();
        $aData = [
            'numero' => $sNumeroContainerExists,
            'tara' => $aDataInputs['tara_container_edit'],
            'tipo_iso_id' => $aDataInputs['tipo_iso_container_edit'],
            'armador_id' => $aDataInputs['armador_container_edit']
        ];

        $oContainerExist = TableRegistry::getTableLocator()->get('Containers')->find()
            ->where(['numero' => $aData['numero']])
            ->first();

        if ($oContainerExist)
            return $oResponse
                ->setStatus(400)
                ->setMessage('O container ' . $aData['numero'] . ' já existe no sistema.')
                ->setTitle('Ops...');

        $oContainer = TableRegistry::getTableLocator()->get('Containers')->newEntity($aData);

        if (TableRegistry::getTableLocator()->get('Containers')->save($oContainer)) {
            $oContainer = TableRegistry::getTableLocator()->get('Containers')->find()
                ->contain(['TipoIsos' => ['ContainerTamanhos']])
                ->select([
                    'container_id_edit'       => 'Containers.id',
                    'numero_container_edit'   => 'Containers.numero',
                    'armador_container_edit'  => 'Containers.armador_id',
                    'tipo_iso_container_edit' => 'TipoIsos.id',
                    'tara_container_edit'     => 'Containers.tara',
                ])
                ->where(['numero' => $oContainer->numero])
                ->first();

            return $oResponse
                ->setStatus(200)
                ->setMessage('Container salvo com sucesso!')
                ->setTitle('Sucesso!')
                ->setDataExtra($oContainer);
        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao cadastrar container!')
            ->setTitle('Ops...!');
    }

    public static function saveContainerResv($aRequestData)
    {
        $aData = [
            'numero'      => $aRequestData['numero_container'],
            'armador_id'  => $aRequestData['armador_id'],
            'tipo_iso_id' => $aRequestData['tipo_iso_id']
        ];

        $entityContainer = TableRegistry::getTableLocator()->get('Containers');
        $oContainer      = $entityContainer->newEntity($aData);

        if ($entityContainer->save($oContainer)) {
            return $oContainer->id;
        }

        return false;
    }

    public static function verifyEstoqueContainer($iContainerID, $sTipoContainer)
    {
        $oResponse = new ResponseUtil();

        if ($iContainerID)
            $oEstoqueEndereco = LgDbUtil::getFind('EstoqueEnderecos')
                ->where([
                    'container_id' => $iContainerID
                ])
                ->first();

        if (!$oEstoqueEndereco)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops. Sem Estoque!')
                ->setMessage('Parece que o container digitado não está no estoque!');

        if ($oEstoqueEndereco->produto_id && $sTipoContainer == 'VAZIO')
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops. Container Cheio!')
                ->setMessage('Parece que o container digitado está cheio no estoque, e não vazio conforme informado!');

        if (!$oEstoqueEndereco->produto_id && $sTipoContainer == 'CHEIO')
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops. Container Vazio!')
                ->setMessage('Parece que o container digitado está vazio no estoque, e não cheio conforme informado!');
                
        return $oResponse
            ->setStatus(200);
    }

    public static function isContainerVazio($oEstoqueEndereco)
    {
        return $oEstoqueEndereco->unidade_medida_id == 22;
    }

    public static function isContainerCheio($oEstoqueEndereco)
    {
        return $oEstoqueEndereco->unidade_medida_id != 22;
    }

    public static function setArmadorByContainer($iContainerID, $iArmadorID)
    {
        $oResponse = new ResponseUtil;

        $oContainer = LgDbUtil::getFind('Containers')
            ->where(['Containers.id' => $iContainerID])
            ->first();

        if (!$oContainer)
            return $oResponse
                ->setStatus(400)
                ->settitle('Ops!')
                ->setMessage('Container não encontrado!');

        $oContainer->armador_id = $iArmadorID ?: null;
        if (LgDbUtil::save('Containers', $oContainer))
            return $oResponse
                ->setStatus(200)
                ->settitle('Sucesso!')
                ->setMessage('Armador atualizado com sucesso!');

        if (!$oContainer)
            return $oResponse
                ->setStatus(400)
                ->settitle('Ops!')
                ->setMessage('Erro ao atualizar armador!');
    }

    public static function getArrayArmadoresByArrayContainers($aContainers)
    {
        return LgDbUtil::getFind('Containers')
            ->where(['id IN' => $aContainers])
            ->distinct('armador_id')
            // ->extract('armador_id')
            ->select(['keyField' => 'id', 'valueField' => 'armador_id'])
            ->toArray();
    }

    public static function getClienteDocumento($iContainerID, $iOperacaoID, $iDocumento)
    {
        $oResponse = new ResponseUtil();

        if (Resv::isDescarga(null, $iOperacaoID)) {

            if ($iContainerID)
                $oResponse = Container::getClienteDocumentoEntradaByContainerId($iContainerID);
            else if ($iDocumento)
                $oResponse = Container::getClienteDocumentoEntradaByDocumentoId($iDocumento);

        } else if (Resv::isCarga(null, $iOperacaoID)) {

            if ($iContainerID)
                $oResponse = Container::getClienteLiberacaoDocumentalByContainerId($iContainerID);
            else if ($iDocumento)
                $oResponse = Container::getClienteLiberacaoDocumentalByDocumentoId($iDocumento);

        } else {

            $oResponse->setStatus(400);

        }

        return $oResponse;
    }

    private static function getClienteDocumentoEntradaByContainerId($iContainerID)
    {
        $oResponse = new ResponseUtil();

        $oItemContainer = LgDbUtil::getFind('ItemContainers')
            ->contain(['DocumentosMercadoriasItens' => ['DocumentosMercadorias' => ['Clientes']]])
            ->where(['ItemContainers.container_id' => $iContainerID])
            ->order(['ItemContainers.id' => 'DESC'])
            ->first();

        if (!$oItemContainer->documentos_mercadorias_item->documentos_mercadoria->cliente)
            return $oResponse->setStatus(400);
                
        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['cliente' => $oItemContainer->documentos_mercadorias_item->documentos_mercadoria->cliente]);
    }

    private static function getClienteLiberacaoDocumentalByContainerId($iContainerID)
    {
        $oResponse = new ResponseUtil();

        $oLiberacaoDocumentalItem = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->contain(['LiberacoesDocumentais' => ['Clientes']])
            ->where(['LiberacoesDocumentaisItens.container_id' => $iContainerID])
            ->order(['LiberacoesDocumentaisItens.id' => 'DESC'])
            ->first();

        if (!$oLiberacaoDocumentalItem->liberacoes_documental->cliente)
            return $oResponse->setStatus(400);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['cliente' => $oLiberacaoDocumentalItem->liberacoes_documental->cliente]);
    }

    private static function getClienteDocumentoEntradaByDocumentoId($iDocumento)
    {
        $oResponse = new ResponseUtil();

        $oDocumentoEntrada = LgDbUtil::getFind('DocumentosTransportes')
            ->contain(['DocumentosMercadorias' => ['Clientes']])
            ->where([
                'DocumentosTransportes.id' => $iDocumento,
                'DocumentosMercadorias.documento_mercadoria_id_master IS NOT NULL' 
            ])
            ->first();

        if (!$oDocumentoEntrada->documentos_mercadoria->cliente)
            return $oResponse->setStatus(400);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['cliente' => $oDocumentoEntrada->documentos_mercadoria->cliente]);
    }

    private static function getClienteLiberacaoDocumentalByDocumentoId($iDocumento)
    {
        $oResponse = new ResponseUtil();

        $iDocumento = explode('_', $iDocumento);
        
        $oLiberacaoDocumental = LgDbUtil::getFind('LiberacoesDocumentais')
            ->contain(['Clientes'])
            ->where(['LiberacoesDocumentais.id' => $iDocumento[1]])
            ->first();

        if (!$oLiberacaoDocumental->cliente)
            return $oResponse->setStatus(400);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['cliente' => $oLiberacaoDocumental->cliente]);
    }

    public static function getDadosTfaDesova($iOSID, $iContainerID)
    {
        $aDadosAvarias = [];
        $aDadosAvarias['empresa_padrao']       = self::getEmpresaPadrao();
        $aDadosAvarias['documento_transporte'] = self::getDadosDocumentoTransporte($iOSID, $iContainerID);
        $aDadosAvarias['datas_horas_veiculo']  = self::getDatasHorasVeiculo($iOSID);
        $aDadosAvarias['dados_avarias']        = self::getOrdemServicoAvarias($iOSID, $iContainerID);
        $aDadosAvarias['ordem_servico_fotos']  = self::getFotosOrdemServico($iOSID, $iContainerID);

        return $aDadosAvarias;
    }

    private static function getEmpresaPadrao()
    {
        $iEmpresaPadrao = Empresa::getEmpresaPadrao();
        $oEmpresa       = LgDbUtil::getFirst('Empresas', ['id' => $iEmpresaPadrao]);

        $aDadosEmpresa = [];
        $aDadosEmpresa['descricao'] = $oEmpresa->descricao;
        $aDadosEmpresa['cnpj']      = $oEmpresa->cnpj;

        return $aDadosEmpresa;
    }

    private static function getDadosDocumentoTransporte($iOSID, $iContainerID)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->select(['resv_id'])
            ->where(['OrdemServicos.id' => $iOSID])
            ->first();

        $oResvContainer = LgDbUtil::getFind('ResvsContainers')
            ->contain([
                'Containers',
                'Resvs' => [
                    'Transportadoras'
                ]
            ])
            ->innerJoinWith('DocumentosTransportes', function ($q) {
                return $q->contain('DocumentosMercadorias', function ($q) {
                    return $q->contain([
                        'ProcedenciasOrigens',
                        'Clientes'
                    ])->where(['DocumentosMercadorias.documento_mercadoria_id_master IS NOT' => null]);
                });
            })
            ->where([
                'resv_id'      => $oOrdemServico->resv_id,
                'container_id' => $iContainerID
            ])
            ->first();

        $oDocTransporte = $oResvContainer->documentos_transporte;
        $oDocMercadoria = $oDocTransporte->documentos_mercadoria;
        $oResv          = $oResvContainer->resv;

        return [
            'numero_documento'   => $oDocTransporte->numero,
            'procedencia_origem' => $oDocMercadoria->procedencias_origem ? $oDocMercadoria->procedencias_origem->sigla : '',
            'transportadora'     => $oResv->transportadora ? $oResv->transportadora->cnpj . ' - ' . $oResv->transportadora->razao_social : '',
            'container'          => $oResvContainer->container->numero,
            'peso'               => $oDocMercadoria->peso_bruto,
            'valor'              => DocumentosMercadoria::getValorTotal($oDocTransporte->id),
            'cliente'            => $oDocMercadoria->cliente ? $oDocMercadoria->cliente->cnpj . ' - ' . $oDocMercadoria->cliente->descricao : ''
        ];
    }

    private static function getDatasHorasVeiculo($iOSID)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->select(['resv_id'])
            ->where(['OrdemServicos.id' => $iOSID])
            ->first();

        $oResv = LgDbUtil::getFirst('Resvs', ['Resvs.id' => $oOrdemServico->resv_id]);

        $aDatas['data_hora_um']['titulo']   = 'Data/Hora Chegada:';
        $aDatas['data_hora_dois']['titulo'] = 'Data/Hora Entrada:';
        $aDatas['data_hora_tres']['titulo'] = 'Data/Hora Saída:';

        $aDatas['data_hora_um']['data']   = DateUtil::dateTimeFromDB($oResv->data_hora_chegada, 'd/m/Y H:i', ' ');
        $aDatas['data_hora_dois']['data'] = DateUtil::dateTimeFromDB($oResv->data_hora_entrada, 'd/m/Y H:i', ' ');
        $aDatas['data_hora_tres']['data'] = DateUtil::dateTimeFromDB($oResv->data_hora_saida, 'd/m/Y H:i', ' ');

        return $aDatas;
    }

    private static function getOrdemServicoAvarias($iOSID, $iContainerID)
    {
        return LgDbUtil::getFind('OrdemServicoAvarias')
            ->contain([
                'Avarias', 
                'AvariaTipos'
            ])
            ->where([
                'ordem_servico_id' => $iOSID,
                'container_id'     => $iContainerID
            ])
            ->toArray();
    }

    private static function getFotosOrdemServico($iOSID, $iContainerID)
    {
        return LgDbUtil::getFind('OrdemServicoFotoAvarias')
            ->contain(['Anexos'])
            ->where(['ordem_servico_id' => $iOSID])
            ->toArray();
    }
    
}
