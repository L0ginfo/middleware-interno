<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaComentarios Model
 *
 * @property \App\Model\Table\MapaComentarioTiposTable&\Cake\ORM\Association\BelongsTo $MapaComentarioTipos
 * @property \App\Model\Table\MapaComentarioAcoesTable&\Cake\ORM\Association\BelongsTo $MapaComentarioAcoes
 *
 * @method \App\Model\Entity\MapaComentario get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaComentario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaComentario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaComentario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaComentario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaComentario findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaComentariosTable extends Table
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
        

        $this->setTable('mapa_comentarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('MapaComentarioTipos', [
            'foreignKey' => 'mapa_comentario_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('MapaComentarioAcoes', [
            'foreignKey' => 'mapa_comentario_acao_id',
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
            ->scalar('comentario')
            ->requirePresence('comentario', 'create')
            ->notEmptyString('comentario');

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
        $rules->add($rules->existsIn(['mapa_comentario_tipo_id'], 'MapaComentarioTipos'));
        $rules->add($rules->existsIn(['mapa_comentario_acao_id'], 'MapaComentarioAcoes'));

        return $rules;
    }
}
