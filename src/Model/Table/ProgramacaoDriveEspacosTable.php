<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoDriveEspacos Model
 *
 * @property \App\Model\Table\DriveEspacosTable&\Cake\ORM\Association\BelongsTo $DriveEspacos
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 *
 * @method \App\Model\Entity\ProgramacaoDriveEspaco get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDriveEspaco findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoDriveEspacosTable extends Table
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
        

        $this->setTable('programacao_drive_espacos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DriveEspacos', [
            'foreignKey' => 'drive_espaco_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
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
        $rules->add($rules->existsIn(['drive_espaco_id'], 'DriveEspacos'));
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));

        return $rules;
    }
}
