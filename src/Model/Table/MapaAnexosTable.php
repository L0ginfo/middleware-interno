<?php
namespace App\Model\Table;

use App\Model\Entity\MapaTransacaoHistorico;
use App\Util\EntityUtil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaAnexos Model
 *
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 * @property \App\Model\Table\MapasTable&\Cake\ORM\Association\BelongsTo $Mapas
 *
 * @method \App\Model\Entity\MapaAnexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaAnexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaAnexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaAnexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaAnexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaAnexo findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaAnexosTable extends Table
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
        

        $this->setTable('mapa_anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Anexos', [
            'foreignKey' => 'anexo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Mapas', [
            'foreignKey' => 'mapa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MapaAnexoTipos', [
            'foreignKey' => 'mapa_anexo_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT',
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
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));
        $rules->add($rules->existsIn(['mapa_id'], 'Mapas'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        MapaTransacaoHistorico::consistencyStatusMapa(EntityUtil::getArrayColumnsModified($entity), $entity->mapa_id);
    }
}
