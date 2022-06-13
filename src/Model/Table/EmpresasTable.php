<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Empresas Model
 *
 * @property \App\Model\Table\CidadesTable&\Cake\ORM\Association\BelongsTo $Cidades
 * @property \App\Model\Table\TiposEmpresasTable&\Cake\ORM\Association\BelongsTo $TiposEmpresas
 * @property \App\Model\Table\UfsTable&\Cake\ORM\Association\BelongsTo $Ufs
 * @property \App\Model\Table\LogradourosTable&\Cake\ORM\Association\BelongsTo $Logradouros
 * @property \App\Model\Table\TipoServicoBancariosTable&\Cake\ORM\Association\BelongsTo $TipoServicoBancarios
 * @property \App\Model\Table\ApreensoesTable&\Cake\ORM\Association\HasMany $Apreensoes
 * @property \App\Model\Table\AreasTable&\Cake\ORM\Association\HasMany $Areas
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\HasMany $DocumentosMercadorias
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\HasMany $DocumentosTransportes
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\HasMany $Enderecos
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\HasMany $EstoqueEnderecos
 * @property \App\Model\Table\EstoquesTable&\Cake\ORM\Association\HasMany $Estoques
 * @property \App\Model\Table\EtiquetaProdutosTable&\Cake\ORM\Association\HasMany $EtiquetaProdutos
 * @property \App\Model\Table\FaturamentoArmazenagensTable&\Cake\ORM\Association\HasMany $FaturamentoArmazenagens
 * @property \App\Model\Table\FaturamentoServicosTable&\Cake\ORM\Association\HasMany $FaturamentoServicos
 * @property \App\Model\Table\FaturamentosTable&\Cake\ORM\Association\HasMany $Faturamentos
 * @property \App\Model\Table\FuncionalidadesTable&\Cake\ORM\Association\HasMany $Funcionalidades
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\HasMany $LiberacoesDocumentais
 * @property \App\Model\Table\LocaisTable&\Cake\ORM\Association\HasMany $Locais
 * @property \App\Model\Table\NcmsTable&\Cake\ORM\Association\HasMany $Ncms
 * @property \App\Model\Table\OrdemServicoCarregamentosTable&\Cake\ORM\Association\HasMany $OrdemServicoCarregamentos
 * @property \App\Model\Table\OrdemServicoEtiquetaCarregamentosTable&\Cake\ORM\Association\HasMany $OrdemServicoEtiquetaCarregamentos
 * @property \App\Model\Table\OrdemServicoServexecsTable&\Cake\ORM\Association\HasMany $OrdemServicoServexecs
 * @property \App\Model\Table\OrdemServicoTiposTable&\Cake\ORM\Association\HasMany $OrdemServicoTipos
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\HasMany $OrdemServicos
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\HasMany $Portarias
 * @property \App\Model\Table\ProdutosTable&\Cake\ORM\Association\HasMany $Produtos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\HasMany $TabelasPrecos
 * @property \App\Model\Table\TabelasPrecosOpcoesTable&\Cake\ORM\Association\HasMany $TabelasPrecosOpcoes
 * @property \App\Model\Table\TabelasPrecosServicosTable&\Cake\ORM\Association\HasMany $TabelasPrecosServicos
 * @property \App\Model\Table\TipoEstruturasTable&\Cake\ORM\Association\HasMany $TipoEstruturas
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\HasMany $UnidadeMedidas
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsToMany $Usuarios
 *
 * @method \App\Model\Entity\Empresa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Empresa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Empresa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Empresa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Empresa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Empresa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Empresa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Empresa findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpresasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('empresas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TiposEmpresas', [
            'foreignKey' => 'tipos_empresa_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Ufs', [
            'className'=>'Estados',
            'foreignKey' => 'uf_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('UfsLeft', [
            'className'=>'Estados',
            'foreignKey' => 'uf_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Logradouros', [
            'foreignKey' => 'logradouro_id'
        ]);
        $this->belongsTo('TipoServicoBancarios', [
            'foreignKey' => 'tipo_servico_bancario_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('TipoCodigoEmpresas', [
            'foreignKey' => 'tipo_codigo_id',
        ]);

        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id',
            'propertyName' => 'pais',
        ]);

        $this->hasMany('Apreensoes', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Areas', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('DocumentosTransportes', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Enderecos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Estoques', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('FaturamentoArmazenagens', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('FaturamentoServicos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Faturamentos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Funcionalidades', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('LiberacoesDocumentais', [
            'foreignKey' => 'empresa_id'
        ]);

        $this->hasMany('LiberacoesDocumentaisClientes', [
            'className'=> 'LiberacoesDocumentais',
            'propertyName' => 'liberacoes_documental',
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Locais', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Ncms', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('OrdemServicoCarregamentos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('OrdemServicoEtiquetaCarregamentos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('OrdemServicoServexecs', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('OrdemServicoTipos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('OrdemServicos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Portarias', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Produtos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('Resvs', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('TabelasPrecos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('TabelasPrecosOpcoes', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('TabelasPrecosServicos', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('TipoEstruturas', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->hasMany('UnidadeMedidas', [
            'foreignKey' => 'empresa_id'
        ]);
        $this->belongsToMany('Usuarios', [
            'foreignKey' => 'empresa_id',
            'targetForeignKey' => 'usuario_id',
            'joinTable' => 'empresas_usuarios'
        ]);

        $this->belongsToMany('IndexUsuarios', [
            'className'=> 'Usuarios',
            'foreignKey' => 'empresa_id',
            'targetForeignKey' => 'usuario_id',
            'through' => 'EmpresasUsuarios'
        ]);

        $this->hasOne('CertificadoEmpresas');

        $this->hasMany('RfbPerfilEmpresas');

        $this->hasMany('EmpresasRetencoes');

        $this->hasMany('PlanoCargas',[
            'foreignKey' => 'cliente_id',
        ]);

        $this->hasMany('PlanoCargaPoroes',[
            'foreignKey' => 'cliente_id',
        ]);

        $this->hasMany('PlanoCargaPoraoOperadores',[
            'className'=>'PlanoCargaPoroes',
            'foreignKey' => 'operador_id',
        ]);

        $this->hasMany('EmpresaRelacaoTipos',[
            'foreignKey' => 'empresa_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('pais_id')
            ->allowEmptyString('pais_id');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 150)
            ->allowEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 90)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 14)
            ->notEmptyString('cnpj');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 60)
            ->allowEmptyString('endereco');

        $validator
            ->scalar('ra_codigo')
            ->maxLength('ra_codigo', 45)
            ->allowEmptyString('ra_codigo');

        $validator
            ->scalar('cidade')
            ->maxLength('cidade', 255)
            ->allowEmptyString('cidade');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 255)
            ->allowEmptyString('bairro');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 40)
            ->allowEmptyString('cep');

        $validator
            ->scalar('complemento')
            ->maxLength('complemento', 255)
            ->allowEmptyString('complemento');

        $validator
            ->scalar('numero')
            ->maxLength('numero', 10)
            ->allowEmptyString('numero');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 20)
            ->allowEmptyString('telefone');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('inscricao_estadual')
            ->maxLength('inscricao_estadual', 255)
            ->allowEmptyString('inscricao_estadual');

        $validator
            ->scalar('inscricao_municipal')
            ->maxLength('inscricao_municipal', 255)
            ->allowEmptyString('inscricao_municipal');

        $validator
            ->scalar('codigo_atividade_economica')
            ->maxLength('codigo_atividade_economica', 255)
            ->allowEmptyString('codigo_atividade_economica');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tipos_empresa_id'], 'TiposEmpresas'));
        // $rules->add($rules->existsIn(['uf_id'], 'Ufs'));
        $rules->add($rules->existsIn(['logradouro_id'], 'Logradouros'));
        // $rules->add($rules->existsIn(['tipo_servico_bancario_id'], 'TipoServicoBancarios'));

        return $rules;
    }
}
