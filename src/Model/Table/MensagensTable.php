<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mensagens Model
 *
 * @property \App\Model\Table\TipoMensagensTable&\Cake\ORM\Association\BelongsTo $TipoMensagens
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\Mensagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mensagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mensagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mensagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mensagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mensagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mensagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mensagem findOrCreate($search, callable $callback = null, $options = [])
 */
class MensagensTable extends Table
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
        

        $this->setTable('mensagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoMensagens', [
            'foreignKey' => 'tipo_mensagem_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
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
            ->scalar('assunto')
            ->maxLength('assunto', 255)
            ->requirePresence('assunto', 'create')
            ->notEmptyString('assunto');

        $validator
            ->dateTime('data')
            ->requirePresence('data', 'create')
            ->notEmptyDateTime('data');

        $validator
            ->scalar('texto')
            ->allowEmptyString('texto');

        $validator
            ->scalar('emails')
            ->allowEmptyString('emails');

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
        $rules->add($rules->existsIn(['tipo_mensagem_id'], 'TipoMensagens'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
