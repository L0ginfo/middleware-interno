<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegimesAduaneiros Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\HasMany $DocumentosMercadorias
 *
 * @method \App\Model\Entity\RegimesAduaneiro get($primaryKey, $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegimesAduaneiro findOrCreate($search, callable $callback = null, $options = [])
 */
class RegimesAduaneirosTable extends Table
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

        $this->setTable('regimes_aduaneiros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'regimes_aduaneiro_id'
        ]);
        $this->hasMany('RegimeAduaneiroTipoFaturamentos', [
            'foreignKey' => 'regime_aduaneiro_id'
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
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->integer('dias_vencimento')
            ->allowEmptyString('dias_vencimento');

        return $validator;
    }
}
