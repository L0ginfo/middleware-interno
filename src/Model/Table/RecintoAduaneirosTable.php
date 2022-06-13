<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecintoAduaneiros Model
 *
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\HasMany $LiberacoesDocumentais
 *
 * @method \App\Model\Entity\RecintoAduaneiro get($primaryKey, $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecintoAduaneiro findOrCreate($search, callable $callback = null, $options = [])
 */
class RecintoAduaneirosTable extends Table
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
        

        $this->setTable('recinto_aduaneiros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('LiberacoesDocumentais', [
            'foreignKey' => 'recinto_aduaneiro_id',
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
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('sigla')
            ->maxLength('sigla', 255)
            ->allowEmptyString('sigla');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 255)
            ->requirePresence('cnpj', 'create')
            ->notEmptyString('cnpj');

        $validator
            ->scalar('urf')
            ->maxLength('urf', 255)
            ->allowEmptyString('urf');

        $validator
            ->integer('tipo_operacao')
            ->allowEmptyString('tipo_operacao');

        $validator
            ->integer('zona_secundaria')
            ->allowEmptyString('zona_secundaria');

        return $validator;
    }
}
