<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoMensagens Model
 *
 * @property \App\Model\Table\MensagensTable&\Cake\ORM\Association\HasMany $Mensagens
 *
 * @method \App\Model\Entity\TipoMensagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoMensagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoMensagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoMensagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMensagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMensagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMensagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMensagem findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoMensagensTable extends Table
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
        

        $this->setTable('tipo_mensagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Mensagens', [
            'foreignKey' => 'tipo_mensagem_id',
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
