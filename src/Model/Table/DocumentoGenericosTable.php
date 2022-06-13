<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentoGenericos Model
 *
 * @property \App\Model\Table\DocumentoGenericoTiposTable&\Cake\ORM\Association\HasMany $DocumentoGenericoTipos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsToMany $Resvs
 *
 * @method \App\Model\Entity\DocumentoGenerico get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentoGenerico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentoGenerico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenerico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoGenerico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentoGenerico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenerico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentoGenerico findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentoGenericosTable extends Table
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
        

        $this->setTable('documento_genericos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentoGenericoTipos', [
            'foreignKey' => 'documento_generico_id',
        ]);
        $this->belongsToMany('Resvs', [
            'foreignKey' => 'documento_generico_id',
            'targetForeignKey' => 'resv_id',
            'joinTable' => 'resvs_documento_genericos',
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
            ->scalar('numero')
            ->maxLength('numero', 255)
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        return $validator;
    }
}
