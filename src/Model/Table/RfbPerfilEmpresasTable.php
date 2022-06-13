<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RfbPerfilEmpresas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsTo $Perfis
 *
 * @method \App\Model\Entity\RfbPerfilEmpresa get($primaryKey, $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RfbPerfilEmpresa findOrCreate($search, callable $callback = null, $options = [])
 */
class RfbPerfilEmpresasTable extends Table
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
        

        $this->setTable('rfb_perfil_empresas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RfbPerfis', [
            'foreignKey' => 'perfil_id',
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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['perfil_id'], 'RfbPerfis'));

        return $rules;
    }
}
