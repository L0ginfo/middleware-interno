<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaTransacaoTipos Model
 *
 * @property \App\Model\Table\MapaTransacaoHistoricosTable&\Cake\ORM\Association\HasMany $MapaTransacaoHistoricos
 *
 * @method \App\Model\Entity\MapaTransacaoTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaTransacaoTiposTable extends Table
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
        

        $this->setTable('mapa_transacao_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('MapaTransacaoHistoricos', [
            'foreignKey' => 'mapa_transacao_tipo_id',
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
            ->scalar('mensagem')
            ->requirePresence('mensagem', 'create')
            ->notEmptyString('mensagem');

        return $validator;
    }
}
