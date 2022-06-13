<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaAvarias Model
 *
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\BelongsTo $Vistorias
 * @property \App\Model\Table\VistoriaItensTable&\Cake\ORM\Association\BelongsTo $VistoriaItens
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 * @property \App\Model\Table\VistoriaAvariaRespostasTable&\Cake\ORM\Association\HasMany $VistoriaAvariaRespostas
 *
 * @method \App\Model\Entity\VistoriaAvaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaAvaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaAvaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvaria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaAvaria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaAvaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaAvaria findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaAvariasTable extends Table
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
        

        $this->setTable('vistoria_avarias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Vistorias', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->belongsTo('VistoriaItens', [
            'foreignKey' => 'vistoria_item_id',
        ]);
        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
        ]);
        $this->hasMany('VistoriaAvariaRespostas', [
            'foreignKey' => 'vistoria_avaria_id',
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

        // $validator
        //     ->decimal('volume')
        //     ->allowEmptyString('volume');

        // $validator
        //     ->decimal('peso')
        //     ->allowEmptyString('peso');

        // $validator
        //     ->decimal('lacre')
        //     ->allowEmptyString('lacre');

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
        $rules->add($rules->existsIn(['vistoria_id'], 'Vistorias'));
        $rules->add($rules->existsIn(['vistoria_item_id'], 'VistoriaItens'));
        $rules->add($rules->existsIn(['avaria_id'], 'Avarias'));

        return $rules;
    }
}
