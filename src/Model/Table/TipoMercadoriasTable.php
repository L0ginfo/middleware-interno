<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoMercadorias Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\HasMany $DocumentosMercadorias
 *
 * @method \App\Model\Entity\TipoMercadoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoMercadoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoMercadoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoMercadoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMercadoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoMercadoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMercadoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoMercadoria findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoMercadoriasTable extends Table
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

        $this->setTable('tipo_mercadorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'tipo_mercadoria_id'
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
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        return $validator;
    }
}
