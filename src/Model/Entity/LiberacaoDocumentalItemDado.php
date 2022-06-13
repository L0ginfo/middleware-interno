<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\Http\Client\Response;
use Cake\ORM\Entity;

class LiberacaoDocumentalItemDado extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters($aDataQuery)
    {
        // $aBeneficiariosWhere = [];
        // if (@$aDataQuery['beneficiario']['values'][0])
        //     $aBeneficiariosWhere += ['Empresas.id' => $aDataQuery['beneficiario']['values'][0]];
        // $aBeneficiarios = LgDbUtil::get('Empresas')
        //     ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
        //     ->select( ['id', 'descricao'] )
        //     ->where($aBeneficiariosWhere)
        //     ->limit(1);

        $aLiberacoesWhere = [];
        if (@$aDataQuery['numero']['values'][0])
            $aLiberacoesWhere += ['LiberacoesDocumentais.id' => $aDataQuery['numero']['values'][0]];
        $aLiberacoes = LgDbUtil::get('LiberacoesDocumentais')
            ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
            ->contain(['TipoDocumentos'])
            ->select([
                'id',
                'numero' => LgDbUtil::getFind('TipoDocumentos')->func()->concat([
                    'tipo_documento' => 'identifier', 
                    ' - ', 
                    'numero' => 'identifier'
                ])
            ])
            ->where($aLiberacoesWhere)
            ->limit(1);

        $aTipoDocumentos = LgdbUtil::get('TipoDocumentos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        return [
            [
                'name'  => 'documento_tipo',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo Documento',
                'table' => [
                    'className' => 'LiberacoesDocumentais.TipoDocumentos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aTipoDocumentos,
                    'required'  => true,

                ]
            ],
            [
                'name'  => 'numero',
                'divClass' => 'col-lg-2',
                'label' => 'Número',
                'table' => [
                    'className' => 'LiberacoesDocumentais',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'required'     => true,
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'numero_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'LiberacoesDocumentais', 'action' => 'filterQuerySelectpickerNumero'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'numero', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aLiberacoes,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            // [
            //     'name'  => 'beneficiario',
            //     'divClass' => 'col-lg-2',
            //     'label' => 'Benefíciario',
            //     'table' => [
            //         'className' => 'LiberacoesDocumentais.Clientes',
            //         'field'     => 'id',
            //         'operacao'  => 'contem',
            //         'type'      => 'select-ajax',
            //         'arrayParamns' => [
            //             'class'        => 'not-fix-width',
            //             'required'     => true,
            //             'label'        => false,
            //             'null'         => true,
            //             'search'       => true,
            //             'name'         => 'beneficiario_id_find',
            //             'options'      =>  [],
            //             'url'          => ['controller' => 'LiberacoesDocumentais', 'action' => 'filterQuerySelectpickerBeneficiario'],
            //             'data'         => [
            //                 'busca' => '{{{q}}}',
            //                 'value' => 'descricao', 
            //                 'key'   => 'id'
            //             ],
            //             'options_ajax' => $aBeneficiarios,
            //             'value'        => null,
            //             'selected'     => null,
            //         ]
            //     ]
            // ],
        ];
    }

    public static function getLiberacaoDocumentalItemDados($aDataQuery)
    {
        $oResponse = new ResponseUtil();

        $oResponseItens = self::getLiberacoesDocumentaisItensByFilter($aDataQuery);
        if ($oResponseItens->getStatus() != 200)
            return $oResponseItens;
            
        $oResponseDados = self::getOrSaveLiberacaoDocumentalItemDados($oResponseItens->getDataExtra());
        if ($oResponseDados->getStatus() != 200)
            return $oResponseDados;

        $aLiberacaoDocumentalItemDados = LgDbUtil::getFind('LiberacaoDocumentalItemDados')
            ->contain([
                'Produtos',
                'Procedencias',
                'DocumentosMercadoriasLote',
                'LiberacoesDocumentais' => [
                    'TipoDocumentos',
                    'Clientes'
                ]
            ])
            ->where(self::getWhereByFilters($aDataQuery));

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aLiberacaoDocumentalItemDados);
    }
    
    private static function getLiberacoesDocumentaisItensByFilter($aDataQuery)
    {
        $oResponse = new ResponseUtil();

        $aWhere = self::getWhereByFilters($aDataQuery);

        $oLiberacoesDocumentaisItens = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->contain([
                'LiberacoesDocumentais' => [
                    'TipoDocumentos',
                    'Clientes'
                ]
            ])
            ->where($aWhere)
            ->toArray();

        if (!$oLiberacoesDocumentaisItens)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foram encontrados itens para os valores informados!');

        
        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oLiberacoesDocumentaisItens);
    }

    private static function getWhereByFilters($aDataQuery)
    {
        return [
            'TipoDocumentos.id'        => $aDataQuery['documento_tipo']['values'][0],
            'LiberacoesDocumentais.id' => $aDataQuery['numero']['values'][0],
            // 'Clientes.id'              => $aDataQuery['beneficiario']['values'][0],
        ];
    }

    private static function getOrSaveLiberacaoDocumentalItemDados($aLiberacoesDocumentaisItens)
    {
        $oResponse = new ResponseUtil();

        foreach ($aLiberacoesDocumentaisItens as $oLiberacaoItem) {

            $oLiberacaoDocumentalItemDado = self::getLiberacaoDocumentalItemDadosByWhere($oLiberacaoItem);
            if ($oLiberacaoDocumentalItemDado) {

                $oResponse = self::verifyUpdateQuantity($oLiberacaoDocumentalItemDado, $oLiberacaoItem);
                if ($oResponse->getStatus() != 200)
                    return $oResponse;

                continue;

            }

            $oResponse = self::saveLiberacaoDocumentalItemDado($oLiberacaoItem);
            if ($oResponse->getStatus() != 200)
                return $oResponse;
            
        }

        return $oResponse
            ->setStatus(200);
    }

    private static function verifyUpdateQuantity($oLiberacaoDocumentalItemDado, $oLiberacaoItem)
    {
        $oResponse = new ResponseUtil();

        if ($oLiberacaoDocumentalItemDado->quantidade_liberada == $oLiberacaoItem->quantidade_liberada)
            return $oResponse
                ->setStatus(200);

        $oLiberacaoDocumentalItemDado->quantidade_liberada = $oLiberacaoItem->quantidade_liberada;
        if (!LgDbUtil::save('LiberacaoDocumentalItemDados', $oLiberacaoDocumentalItemDado, true))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao atualizar a quantidade da Liberação Documental Item Dados!');
    
        return $oResponse
            ->setStatus(200);
    }

    private static function getLiberacaoDocumentalItemDadosByWhere($oLiberacaoItem)
    {
        $aWhere = [
            'lote_codigo IS'             => $oLiberacaoItem->lote_codigo,
            'lote_item IS'               => $oLiberacaoItem->lote_item,
            'produto_id IS'              => $oLiberacaoItem->produto_id,
            'unidade_medida_id IS'       => $oLiberacaoItem->unidade_medida_id,
            'liberacao_documental_id IS' => $oLiberacaoItem->liberacao_documental_id,
            'lote IS'                    => $oLiberacaoItem->lote,
            'serie IS'                   => $oLiberacaoItem->serie,
            'validade IS'                => $oLiberacaoItem->validade
        ];

        return LgDbUtil::getFind('LiberacaoDocumentalItemDados')
            ->where($aWhere)
            ->first();
    }

    private static function saveLiberacaoDocumentalItemDado($oLiberacaoItem)
    {
        $oResponse = new ResponseUtil();

        $aInsert = [
            'adicao_numero'              => $oLiberacaoItem->adicao_numero,
            'quantidade_liberada'        => $oLiberacaoItem->quantidade_liberada,
            'liberacao_documental_id'    => $oLiberacaoItem->liberacao_documental_id,
            'regime_aduaneiro_id'        => $oLiberacaoItem->regime_aduaneiro_id,
            'estoque_id'                 => $oLiberacaoItem->estoque_id,
            'tabela_preco_id'            => $oLiberacaoItem->tabela_preco_id,
            'lote_codigo'                => $oLiberacaoItem->lote_codigo,
            'lote_item'                  => $oLiberacaoItem->lote_item,
            'qtde_saldo'                 => $oLiberacaoItem->qtde_saldo,
            'peso_saldo'                 => $oLiberacaoItem->peso_saldo,
            'm2_saldo'                   => $oLiberacaoItem->m2_saldo,
            'm3_saldo'                   => $oLiberacaoItem->m3_saldo,
            'lote'                       => $oLiberacaoItem->lote,
            'serie'                      => $oLiberacaoItem->serie,
            'validade'                   => $oLiberacaoItem->validade,
            'unidade_medida_id'          => $oLiberacaoItem->unidade_medida_id,
            'endereco_id'                => $oLiberacaoItem->endereco_id,
            'empresa_id'                 => $oLiberacaoItem->empresa_id,
            'produto_id'                 => $oLiberacaoItem->produto_id,
            'liberacao_por_produto'      => $oLiberacaoItem->liberacao_por_produto,
            'container_id'               => $oLiberacaoItem->container_id,
            'entrada_saida_container_id' => $oLiberacaoItem->entrada_saida_container_id,
        ];

        if (!LgDbUtil::saveNew('LiberacaoDocumentalItemDados', $aInsert, true))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao salvar a Liberação Documental Item Dados!');

        return $oResponse
            ->setStatus(200);
    }

    public static function saveInserirDados($aDataPost)
    {
        $oResponse = new ResponseUtil();

        foreach ($aDataPost['id'] as $key => $value) {
            
            $oLiberacaoDocumentalItemDado = LgDbUtil::getByID('LiberacaoDocumentalItemDados', $value);

            $oLiberacaoDocumentalItemDado->dado_lote        = $aDataPost['lote'][$value];
            $oLiberacaoDocumentalItemDado->porto_destino_id = $aDataPost['porto_destino_id'][$value];

            if (!LgDbUtil::save('LiberacaoDocumentalItemDados', $oLiberacaoDocumentalItemDado, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar inserir os dados!');

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Dados inseridos com sucesso!');
    }

}
