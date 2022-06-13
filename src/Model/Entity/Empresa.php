<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\SaveUtil;
use App\Util\SessionUtil;
use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Empresa Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 * @property string $cnpj
 * @property string|null $endereco
 * @property int|null $cidade_id
 * @property string|null $ra_codigo
 * @property int $tipos_empresa_id
 * @property string $bairro
 * @property string $cep
 * @property int $uf_id
 * @property int|null $logradouro_id
 * @property int $tipo_servico_bancario_id
 * @property string|null $complemento
 * @property string $numero
 * @property string $telefone
 * @property string $email
 * @property string|null $inscricao_estadual
 * @property string|null $inscricao_municipal
 * @property string|null $codigo_atividade_economica
 *
 * @property \App\Model\Entity\Cidade $cidade
 * @property \App\Model\Entity\TiposEmpresa $tipos_empresa
 * @property \App\Model\Entity\Uf $uf
 * @property \App\Model\Entity\Logradouro $logradouro
 * @property \App\Model\Entity\TipoServicoBancario $tipo_servico_bancario
 * @property \App\Model\Entity\Apreensao[] $apreensoes
 * @property \App\Model\Entity\Area[] $areas
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 * @property \App\Model\Entity\DocumentosTransporte[] $documentos_transportes
 * @property \App\Model\Entity\Endereco[] $enderecos
 * @property \App\Model\Entity\EstoqueEndereco[] $estoque_enderecos
 * @property \App\Model\Entity\Estoque[] $estoques
 * @property \App\Model\Entity\EtiquetaProduto[] $etiqueta_produtos
 * @property \App\Model\Entity\FaturamentoArmazenagem[] $faturamento_armazenagens
 * @property \App\Model\Entity\FaturamentoServico[] $faturamento_servicos
 * @property \App\Model\Entity\Faturamento[] $faturamentos
 * @property \App\Model\Entity\Funcionalidade[] $funcionalidades
 * @property \App\Model\Entity\LiberacoesDocumental[] $liberacoes_documentais
 * @property \App\Model\Entity\Local[] $locais
 * @property \App\Model\Entity\Ncm[] $ncms
 * @property \App\Model\Entity\OrdemServicoCarregamento[] $ordem_servico_carregamentos
 * @property \App\Model\Entity\OrdemServicoEtiquetaCarregamento[] $ordem_servico_etiqueta_carregamentos
 * @property \App\Model\Entity\OrdemServicoServexec[] $ordem_servico_servexecs
 * @property \App\Model\Entity\OrdemServicoTipo[] $ordem_servico_tipos
 * @property \App\Model\Entity\OrdemServico[] $ordem_servicos
 * @property \App\Model\Entity\Portaria[] $portarias
 * @property \App\Model\Entity\Produto[] $produtos
 * @property \App\Model\Entity\Resv[] $resvs
 * @property \App\Model\Entity\TabelasPreco[] $tabelas_precos
 * @property \App\Model\Entity\TabelasPrecosOpcao[] $tabelas_precos_opcoes
 * @property \App\Model\Entity\TabelasPrecosServico[] $tabelas_precos_servicos
 * @property \App\Model\Entity\TipoEstrutura[] $tipo_estruturas
 * @property \App\Model\Entity\UnidadeMedida[] $unidade_medidas
 * @property \App\Model\Entity\Usuario[] $usuarios
 */
class Empresa extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * 
        'codigo' => true,
        'descricao' => true,
        'cnpj' => true,
        'endereco' => true,
        'cidade_id' => true,
        'pais_id' => true,
        'ra_codigo' => true,
        'tipos_empresa_id' => true,
        'cidade' => true,
        'bairro' => true,
        'cep' => true,
        'uf_id' => true,
        'logradouro_id' => true,
        'tipo_servico_bancario_id' => true,
        'faturar_planejamento_maritimo' => true,
        'complemento' => true,
        'numero' => true,
        'telefone' => true,
        'email' => true,
        'usa_rfb' => true,
        'token' => true,
        'inscricao_estadual' => true,
        'inscricao_municipal' => true,
        'codigo_atividade_economica' => true,
        'tipos_empresa' => true,
        'uf' => true,
        'logradouro' => true,
        'tipo_servico_bancario' => true,
        'apreensoes' => true,
        'areas' => true,
        'documentos_mercadorias' => true,
        'documentos_transportes' => true,
        'enderecos' => true,
        'estoque_enderecos' => true,
        'estoques' => true,
        'etiqueta_produtos' => true,
        'faturamento_armazenagens' => true,
        'faturamento_servicos' => true,
        'faturamentos' => true,
        'funcionalidades' => true,
        'liberacoes_documentais' => true,
        'locais' => true,
        'ncms' => true,
        'ordem_servico_carregamentos' => true,
        'ordem_servico_etiqueta_carregamentos' => true,
        'ordem_servico_servexecs' => true,
        'ordem_servico_tipos' => true,
        'ordem_servicos' => true,
        'portarias' => true,
        'produtos' => true,
        'resvs' => true,
        'tabelas_precos' => true,
        'tabelas_precos_opcoes' => true,
        'tabelas_precos_servicos' => true,
        'tipo_estruturas' => true,
        'unidade_medidas' => true,
        'usuarios' => true,
        
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getEmpresaByCnpj($oWithNotaFiscal = null, $oWithoutNotaFiscal = null)
    {
        $sCnpj = isset($oWithNotaFiscal->CNPJ) ? $oWithNotaFiscal->CNPJ : $oWithoutNotaFiscal->cnpj;
        $oEmpresa = TableRegistry::get('Empresas')->find()
            ->where([
                'cnpj' => $sCnpj
            ])->first();

        if ($oEmpresa)
            return $oEmpresa->id;

        if($oWithNotaFiscal){
            $oEmpresa = TableRegistry::get('Empresas')->newEntity([
                'codigo'                   => 0,
                'descricao'                => @$oWithNotaFiscal->xNome,
                'cnpj'                     => @$oWithNotaFiscal->CNPJ,
                'endereco'                 => @$oWithNotaFiscal->enderEmit->xLgr,
                'tipos_empresa_id'         => 2,
                'cidade'                   => @$oWithNotaFiscal->enderEmit->xMun ?: '-',
                'bairro'                   => @$oWithNotaFiscal->enderEmit->xBairro ?: '-',
                'cep'                      => @$oWithNotaFiscal->enderEmit->CEP ?: '-',
                'telefone'                 => @$oWithNotaFiscal->enderEmit->fone ?: '-',
                'uf_id'                    => 1,
                'tipo_servico_bancario_id' => 1,
                'complemento'              => @$oWithNotaFiscal->enderEmit->xCpl,
                'numero'                   => @$oWithNotaFiscal->enderEmit->nro ?: '-',
                'pais_id'                  => 1,
                'email'                    => @$oWithNotaFiscal->CNPJ . '@' . @$oWithNotaFiscal->CNPJ . '.com.br'
            ]);
        }
        else {
            $oEmpresa = TableRegistry::get('Empresas')->newEntity([
                'codigo'                   => 0,
                'descricao'                => @$oWithoutNotaFiscal->descricao,
                'cnpj'                     => @$oWithoutNotaFiscal->cnpj,
                'endereco'                 => isset($oWithoutNotaFiscal->endereco) ? $oWithoutNotaFiscal->endereco : '-',
                'tipos_empresa_id'         => isset($oWithoutNotaFiscal->tipos_empresa_id) ? $oWithoutNotaFiscal->tipos_empresa_id : 2,
                'cidade'                   => isset($oWithoutNotaFiscal->cidade) ? $oWithoutNotaFiscal->cidade : '-',
                'bairro'                   => isset($oWithoutNotaFiscal->bairro) ? $oWithoutNotaFiscal->bairro : '-',
                'cep'                      => isset($oWithoutNotaFiscal->cep) ? $oWithoutNotaFiscal->cep : '-',
                'telefone'                 => isset($oWithoutNotaFiscal->telefone) ? $oWithoutNotaFiscal->telefone : '-',
                'uf_id'                    => 1,
                'tipo_servico_bancario_id' => 1,
                'complemento'              => isset($oWithoutNotaFiscal->complemento) ? $oWithoutNotaFiscal->complemento : '-',
                'numero'                   => isset($oWithoutNotaFiscal->numero) ? $oWithoutNotaFiscal->numero : '-',
                'pais_id'                  => 1,
                'email'                    => isset($oWithoutNotaFiscal->cnpj) ? ($oWithoutNotaFiscal->cnpj . '@' . @$oWithoutNotaFiscal->cnpj . '.com.br') : '-'
            ]);
        }

        if(isset($oEmpresa->descricao) && isset($oEmpresa->cnpj)){
            $oEmpresaSaved = TableRegistry::get('Empresas')->save($oEmpresa);
            if(isset($oEmpresaSaved->id) && isset($oEmpresaSaved->tipos_empresa_id)) {
                try {
                    LgDbUtil::saveNew('EmpresaRelacaoTipos', [
                        'empresa_id' => $oEmpresaSaved->id, 
                        'tipos_empresa_id' => $oEmpresaSaved->tipos_empresa_id
                    ]);
                } catch (\Throwable $th) {}
            }
            return $oEmpresaSaved->id;
        }
        else {
            return null;
        }
    }

    public static function getEmpresaAtual()
    {
        return @$_SESSION['empresa_atual'] ?: 1;
    }

    public static function getEmpresaPadrao()
    {
        return @self::getEmpresaAtual() ?: 1;
    }


    public static function saveRfbPerfil($id, $aData){

        if(empty($id) || empty($aData['rfb_perfis'])){
            return false;
        }

        $oRfbPerfil = LgDbUtil::getFirst('RfbPerfis', ['id' => $aData['rfb_perfis']]);

        if(empty($oRfbPerfil)){
            return false;
        }

        $oRfbPerfilEmpresas = LgDbUtil::getFirst('RfbPerfilEmpresas', ['empresa_id' => $id]);

        if($oRfbPerfilEmpresas){
            $oRfbPerfilEmpresas->perfil_id = $oRfbPerfil->id;
            return LgDbUtil::save('RfbPerfilEmpresas', $oRfbPerfilEmpresas);
        }

        return LgDbUtil::saveNew('RfbPerfilEmpresas', [
            'empresa_id' => $id,
            'perfil_id' => $oRfbPerfil->id
        ]);

    }

    public function getNacionalidade(){
        if($this->pais_id == 1){
            return 1;
        }

        return 2;
    }
    
    public function getCodigoEstrangeiro(){
        if($this->pais_id == 1){
            return '';
        }
        return $this->codigo;
    }

    public static function saveEmpresaRelacaoTipos($id, $aData){
        $oResponse = SaveUtil::multiple($id, [
            'table' => 'EmpresaRelacaoTipos',
            'input' => 'tipos_empresas',
            'id' => 'empresa_id',
            'value' => 'tipos_empresa_id',
        ], $aData);
    }

    public static function getEmpresaMasterUsuario()
    {
        $oEmpresaUsuario = LgDbUtil::getFind('EmpresasUsuarios')
            ->where([
                'usuario_id' => SessionUtil::getUsuarioConectado(),
                'master' => 1
            ])
            ->first();

        return @$oEmpresaUsuario->empresa_id ?: null;
    }

    public static function getEmpresasByPerfil($iPerfilId)
    {
        $aEmpresaUsuarios = LgDbUtil::get('EmpresasUsuarios')
            ->find('list', ['keyField' => 'id', ['valueField' => 'empresa_id']])
            ->where([
                'usuario_id' => SessionUtil::getUsuarioConectado(),
                'perfil_id' => $iPerfilId
            ])
            ->toArray();

        return $aEmpresaUsuarios;
    }
}
