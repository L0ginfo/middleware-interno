<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaLacres Model
 *
 * @property \App\Model\Table\LacreTiposTable&\Cake\ORM\Association\BelongsTo $LacreTipos
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\BelongsTo $Vistorias
 * @property \App\Model\Table\VistoriaItensTable&\Cake\ORM\Association\BelongsTo $VistoriaItens
 *
 * @method \App\Model\Entity\VistoriaLacre get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaLacre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaLacre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaLacre|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaLacre saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaLacre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaLacre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaLacre findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaLacresTable extends Table
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
        

        $this->setTable('vistoria_lacres');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('LacreTipos', [
            'foreignKey' => 'lacre_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Vistorias', [
            'foreignKey' => 'vistoria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('VistoriaItens', [
            'foreignKey' => 'vistoria_item_id',
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
            ->scalar('lacre_numero')
            ->maxLength('lacre_numero', 255)
            ->requirePresence('lacre_numero', 'create')
            ->notEmptyString('lacre_numero');

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
        $rules->add($rules->existsIn(['lacre_tipo_id'], 'LacreTipos'));
        $rules->add($rules->existsIn(['vistoria_id'], 'Vistorias'));
        $rules->add($rules->existsIn(['vistoria_item_id'], 'VistoriaItens'));

        return $rules;
    }
}
