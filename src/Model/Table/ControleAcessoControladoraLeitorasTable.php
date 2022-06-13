<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoControladoraLeitoras Model
 *
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoControladoras
 * @property \App\Model\Table\ControleAcessoEquipamentosTable&\Cake\ORM\Association\BelongsTo $ControleAcessoEquipamentos
 *
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoControladoraLeitora findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoControladoraLeitorasTable extends Table
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
        

        $this->setTable('controle_acesso_controladora_leitoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleAcessoControladoras', [
            'foreignKey' => 'controle_acesso_controladora_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoEquipamentos', [
            'foreignKey' => 'controle_acesso_equipamento_id',
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
        $rules->add($rules->existsIn(['controle_acesso_controladora_id'], 'ControleAcessoControladoras'));
        $rules->add($rules->existsIn(['controle_acesso_equipamento_id'], 'ControleAcessoEquipamentos'));

        return $rules;
    }
}
