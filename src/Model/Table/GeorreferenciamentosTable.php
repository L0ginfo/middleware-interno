<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Georreferenciamentos Model
 *
 * @property \App\Model\Table\GeorreferenciamentoTiposTable&\Cake\ORM\Association\BelongsTo $GeorreferenciamentoTipos
 * @property \App\Model\Table\AreasTable&\Cake\ORM\Association\HasMany $Areas
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\HasMany $Balancas
 * @property \App\Model\Table\CamerasTable&\Cake\ORM\Association\HasMany $Cameras
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\HasMany $ControleAcessoControladoras
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\HasMany $Empresas
 * @property \App\Model\Table\LocaisTable&\Cake\ORM\Association\HasMany $Locais
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\HasMany $Portarias
 *
 * @method \App\Model\Entity\Georreferenciamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\Georreferenciamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Georreferenciamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Georreferenciamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Georreferenciamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Georreferenciamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Georreferenciamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Georreferenciamento findOrCreate($search, callable $callback = null, $options = [])
 */
class GeorreferenciamentosTable extends Table
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
        
        $this->addBehavior('LogsTabelas');
        

        $this->setTable('georreferenciamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('GeorreferenciamentoTipos', [
            'foreignKey' => 'georreferenciamento_tipo_id',
        ]);
        $this->hasMany('Areas', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('Balancas', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('Cameras', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('ControleAcessoControladoras', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('Empresas', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('Locais', [
            'foreignKey' => 'georreferenciamento_id',
        ]);
        $this->hasMany('Portarias', [
            'foreignKey' => 'georreferenciamento_id',
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
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->allowEmptyString('nome');

        $validator
            ->integer('ativo')
            ->allowEmptyString('ativo');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->allowEmptyString('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->allowEmptyString('longitude');

        $validator
            ->integer('id_coluna')
            ->allowEmptyString('id_coluna');

        $validator
            ->scalar('tabela')
            ->maxLength('tabela', 255)
            ->allowEmptyString('tabela');

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
        $rules->add($rules->existsIn(['georreferenciamento_tipo_id'], 'GeorreferenciamentoTipos'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) 
    {
        RfbManager::doAction('rfb', 'evento-georreferenciamento', 'init', $entity, ['nome_model' => 'Integracoes']);  
    }

    public function beforeDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'evento-georreferenciamento', 'init', $entity, ['nome_model' => 'Integracoes', 'operacao' => 'delete']);
    }
    
}
