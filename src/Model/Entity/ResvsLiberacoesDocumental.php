<?php
namespace App\Model\Entity;

use App\RegraNegocio\AutoExecucaoOrdemServico\ExecuteCarga;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;
use App\Util\LgDbUtil;
use App\Util\SessionUtil;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ResvsLiberacoesDocumental Entity
 *
 * @property int $id
 * @property int $resv_id
 * @property int $liberacao_documental_id
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 */
class ResvsLiberacoesDocumental extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     *   'resv_id' => true,
     *   'liberacao_documental_id' => true,
     *   'resv' => true,
     *   'liberacoes_documental' => true
     * @var array
     */
   protected $_accessible = [
      '*' => true,
      'id' => false
   ];

   public static function getResvLiberacoes($array, $resv_id){
       
       if (!$array)
         return [];

        $sSql =  
        'SELECT DISTINCT
            DocumentosMercadoriasMaster.numero_documento AS MAWB,
            DocumentosMercadoriasHouse.numero_documento AS HAWB,
            LiberacoesDocumentais.numero AS documento,
            LiberacoesDocumentais.observacao AS observacao,
            TipoDocumentos.descricao AS tipo_documento,
            Clientes.descricao AS cliente
        FROM liberacoes_documentais AS LiberacoesDocumentais
        INNER JOIN resvs_liberacoes_documentais AS ResvsLiberacoesDocumentais  ON
           LiberacoesDocumentais.id = ResvsLiberacoesDocumentais.liberacao_documental_id
        INNER JOIN liberacoes_documentais_itens AS LiberacoesDocumentaisItens ON
           LiberacoesDocumentaisItens.liberacao_documental_id = LiberacoesDocumentais.id
        INNER JOIN estoques AS Estoques ON 
           Estoques.id = LiberacoesDocumentaisItens.estoque_id
        INNER JOIN etiqueta_produtos AS EtiquetaProdutos ON
           EtiquetaProdutos.lote_codigo = Estoques.lote_codigo AND
           EtiquetaProdutos.lote_item = Estoques.lote_item AND
           EtiquetaProdutos.empresa_id = Estoques.empresa_id
        INNER JOIN documentos_mercadorias_itens AS DocumentosMercadoriasItens ON
           DocumentosMercadoriasItens.id = EtiquetaProdutos.documento_mercadoria_item_id
        INNER JOIN documentos_mercadorias AS DocumentosMercadoriasHouse ON 
           DocumentosMercadoriasHouse.id = DocumentosMercadoriasItens.documentos_mercadoria_id
        INNER JOIN documentos_mercadorias AS DocumentosMercadoriasMaster ON 
           DocumentosMercadoriasMaster.id = DocumentosMercadoriasHouse.documento_mercadoria_id_master
        INNER JOIN tipo_documentos AS TipoDocumentos ON 
            TipoDocumentos.id = LiberacoesDocumentais.tipo_documento_id
        INNER JOIN empresas AS Clientes ON
             Clientes.id = LiberacoesDocumentais.cliente_id
        WHERE 
            DocumentosMercadoriasMaster.documento_mercadoria_id_master IS NULL AND
            ResvsLiberacoesDocumentais.resv_id = '.$resv_id.' AND
            LiberacoesDocumentais.id IN ('.implode(',', $array).')';
        $connection = ConnectionManager::get('default');
        $aDocumentos = $connection->execute( $sSql )->fetchAll('assoc');
        return $aDocumentos;
    }

    public static function getOSPendentesLiberacoesDocumentais($iOSID = null, $bHabitadoConferente = false)
    {
      $oResvsLiberacoesDocumentais = TableRegistry::get('ResvsLiberacoesDocumentais')->find();

      $oNumDocsLD__custom = $oResvsLiberacoesDocumentais->newExpr()
         ->add(
            LgDbUtil::setConcatGroupByDb('LiberacoesDocumentais.numero_documento_liberacao')
         );
      
      $oIDsLD__custom = $oResvsLiberacoesDocumentais->newExpr()
         ->add(
            LgDbUtil::setConcatGroupByDb('LiberacoesDocumentais.id')
         );

      $oSituacoes__custom = $oResvsLiberacoesDocumentais->newExpr()
         ->addCase(
            [
               $oResvsLiberacoesDocumentais->newExpr()->add(
                  '(OrdemServicos.data_hora_fim IS NULL)'
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

      $oResvsLiberacoesDocumentais = self::getQueryByDb($iOSID, $oResvsLiberacoesDocumentais, $oSubQuery, $oSituacoes__custom, $oIDsLD__custom, $oNumDocsLD__custom);

      $bPermiteVerOsCarga = ParametroGeral::getParametroWithValue('PARAM_PERMITE_VER_OS_CARGA');   
      $bMostraTodasOsCarga = ParametroGeral::getParametroWithValue('PARAM_MOSTRA_TODAS_OS_CARGA');   
      if(($bHabitadoConferente && !Perfil::isAdmin() && !$bMostraTodasOsCarga) || ($bPermiteVerOsCarga && !Perfil::isAdmin())){
            $oResvsLiberacoesDocumentais->matching('OrdemServicos.Usuarios', function($q){
               return $q->where(['Usuarios.id' => SessionUtil::getUsuarioConectado()
            ]);
         });
      }

      $oResvsLiberacoesDocumentais = $oResvsLiberacoesDocumentais->toArray();
         
      return $oResvsLiberacoesDocumentais;
   }

   private static function getQueryByDb($iOSID, $oResvsLiberacoesDocumentais, $oSubQuery, $oSituacoes__custom, $oIDsLD__custom, $oNumDocsLD__custom)
   {
      if (env('DB_ADAPTER', 'mysql') == 'mysql') {
         $oResvsLiberacoesDocumentais = $oResvsLiberacoesDocumentais
            ->select([
               'Clientes.descricao',
               'Clientes.cnpj',
               'LiberacoesDocumentais.id',
               'LiberacoesDocumentaisItensLeft.id',
               'DocumentosMercadoriasLote.id',
               'DocumentosMercadoriasLote.numero_documento',
               'EstoqueEnderecosLeftByLote.endereco_id',
               'NaturezasCargas.perigosa',
               'OrdemServicos.id',
               'veiculo_identificacao' => 'Veiculos.veiculo_identificacao',
               'num_doc'               => 'LiberacoesDocumentais.numero_documento_liberacao',
               'documentos_numeros'    => $oNumDocsLD__custom,
               'ids_registry_ld'       => $oIDsLD__custom,
               'situacao'              => $oSituacoes__custom,
               'class_name'            => "'Liberações Documentais'",
               'resv_id',
               'Resvs.id',
               'Produtos.id',
               'Produtos.descricao'
            ])
            ->contain([
               'LiberacoesDocumentais' => [
                  'Clientes', 
                  'LiberacoesDocumentaisItensLeft'  => [
                     'Produtos',
                     'DocumentosMercadoriasLote' => [
                        'NaturezasCargas'
                     ],
                     'EstoqueEnderecosLeftByLote'
                  ]
               ],
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
               'OrdemServicos' => ['Usuarios']
            ])
            ->where([
               'OrdemServicos.ordem_servico_tipo_id = 2',
               'OrdemServicos.data_hora_fim IS NULL',
               'OrdemServicos.resv_id IS NOT NULL',
            ] +
               ($iOSID 
                  ? ['OrdemServicos.id' => $iOSID]
                  : [] 
               ) 
            )
            ->group([
               'OrdemServicos.id', 
               'Veiculos.veiculo_identificacao',
               'Clientes.descricao',
               'Clientes.cnpj',
               'LiberacoesDocumentais.id',
               'NaturezasCargas.perigosa',
               'OrdemServicos.id',
               'Resvs.id'
            ]);
      }else {
         $oResvsLiberacoesDocumentais
            ->select([
               'Clientes.descricao',
               'Clientes.cnpj',
               'LiberacoesDocumentais.id',
               'LiberacoesDocumentaisItensLeft.id',
               'DocumentosMercadoriasLote.id',
               'DocumentosMercadoriasLote.numero_documento',
               'EstoqueEnderecosLeftByLote.endereco_id',
               'NaturezasCargas.perigosa',
               'OrdemServicos.id',
               'veiculo_identificacao' => 'Veiculos.veiculo_identificacao',
               'num_doc'               => 'LiberacoesDocumentais.numero_documento_liberacao',
               'documentos_numeros'    => $oNumDocsLD__custom,
               'ids_registry_ld'       => $oIDsLD__custom,
               'situacao'              => $oSituacoes__custom,
               'class_name'            => "'Liberações Documentais'",
               'resv_id',
               'Resvs.id',
               'Produtos.id',
               'produto_descricao' => 'CAST(Produtos.descricao AS VARCHAR(100))'
            ])
            ->contain([
               'LiberacoesDocumentais' => [
                  'Clientes', 
                  'LiberacoesDocumentaisItensLeft'  => [
                     'Produtos',
                     'DocumentosMercadoriasLote' => [
                        'NaturezasCargas'
                     ],
                     'EstoqueEnderecosLeftByLote'
                  ]
               ],
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
               'OrdemServicos' => ['Usuarios']
            ])
            ->where([
               'OrdemServicos.ordem_servico_tipo_id = 2',
               'OrdemServicos.data_hora_fim IS NULL',
               'OrdemServicos.resv_id IS NOT NULL',
            ] +
               ($iOSID 
                  ? ['OrdemServicos.id' => $iOSID]
                  : [] 
               ) 
            )
            ->group([
               'OrdemServicos.id', 
               'Veiculos.veiculo_identificacao',
               'Clientes.descricao',
               'Clientes.cnpj',
               'LiberacoesDocumentais.id',
               'LiberacoesDocumentaisItensLeft.id',
               'DocumentosMercadoriasLote.id',
               'NaturezasCargas.perigosa',
               'OrdemServicos.id',
               'Resvs.id',
               'Produtos.id',
               'CAST(Produtos.descricao AS VARCHAR(100))',
               'LiberacoesDocumentais.numero_documento_liberacao',
               'OrdemServicos.data_hora_fim',
               'ResvsLiberacoesDocumentais.resv_id',
               'DocumentosMercadoriasLote.numero_documento',
               'EstoqueEnderecosLeftByLote.endereco_id'
            ]);
      }

      return $oResvsLiberacoesDocumentais;
   }

   public static function getLoteCodigosDoMesmoDocumento($oLiberacaoDocumentalItem)
   {
      $sLoteCodigo = $oLiberacaoDocumentalItem->lote_codigo;
      $oDocumentoMercadoriaOriginal = LgDbUtil::getFind('DocumentosMercadorias')
         ->where([
            'lote_codigo' => $sLoteCodigo
         ])
         ->first();
      $aLoteCodigos = LgDbUtil::getFind('DocumentosMercadorias')
         ->where([
            'numero_documento' => $oDocumentoMercadoriaOriginal->numero_documento,
            'tipo_documento_id' => $oDocumentoMercadoriaOriginal->tipo_documento_id,
            'lote_codigo IS NOT' => null,
            'documento_mercadoria_id_master IS NOT' => null
         ])
         ->extract('lote_codigo')
         ->toArray();

      return $aLoteCodigos;
   }

   public static function getEstoqueEnderecosPossiveis($oResv, $bReturnSomenteEnderecos = false)
   {
      $oResponse = ExecuteCarga::getItem($oResv);

      $oLiberacaoDocumentalItem = $oResponse->getStatus() == 200 
         ? $oResponse->getDataExtra()['liberacao_documental_item']
         : null;

      if (!$oLiberacaoDocumentalItem)
         return [];

      $aConditions = ProdutosControlados::getProdutoControlesValuesToQuery($oLiberacaoDocumentalItem, false, false, false);

      if (array_key_exists('lote_codigo IS', $aConditions)) 
         unset($aConditions['lote_codigo IS']);

      if (array_key_exists('lote_item IS', $aConditions)) 
         unset($aConditions['lote_item IS']);
      
      $aEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
         ->contain([
            'Enderecos' => [
                  'Areas' => [
                     'Locais'
                  ]
            ]
         ])
         ->where($aConditions)
         ->toArray();

      if (!$aEstoqueEnderecos)
         return [];
      
      $aEstoqueEnderecosPossiveis = [];
      $aEnderecoIDs = [];

      foreach ($aEstoqueEnderecos as $oEstoqueEndereco) {
         $aEstoqueEnderecosPossiveis[$oEstoqueEndereco->endereco_id] = [
            'qtde_saldo' => $oEstoqueEndereco->qtde_saldo,
            'estoque_endereco_id' => $oEstoqueEndereco->id,
            'endereco_id' => $oEstoqueEndereco->endereco_id,
         ];

         $aEnderecoIDs[$oEstoqueEndereco->endereco_id] = true;
      }

      if ($bReturnSomenteEnderecos)
         return array_keys($aEnderecoIDs);

      return $aEstoqueEnderecosPossiveis;
   }

   public static function getPesagemResvsLiberacoesDocumentais($iResvID)
   {
       $aResvsLiberacoesDocumentais = LgDbUtil::getFind('ResvsLiberacoesDocumentais')->contain([
         'LiberacoesDocumentais' => [
             'Clientes',
             'LiberacoesDocumentaisItensLeftMany' => [
                 'Produtos'
             ]
         ],
         'LiberacaoDocumentalTransportadoras'
     ])->where(['ResvsLiberacoesDocumentais.resv_id' => $iResvID])->toArray();
     return $aResvsLiberacoesDocumentais;
   }
}
