<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirecaoControladoras Model
 *
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\HasMany $ControleAcessoControladoras
 * @property \App\Model\Table\ControleAcessoLogsTable&\Cake\ORM\Association\HasMany $ControleAcessoLogs
 *
 * @method \App\Model\Entity\DirecaoControladora get($primaryKey, $options = [])
 * @method \App\Model\Entity\DirecaoControladora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DirecaoControladora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DirecaoControladora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirecaoControladora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirecaoControladora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DirecaoControladora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DirecaoControladora findOrCreate($search, callable $callback = null, $options = [])
 */
class DirecaoControladorasTable extends Table
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
        

        $this->setTable('direcao_controladoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('ControleAcessoControladoras', [
            'foreignKey' => 'direcao_controladora_id',
        ]);
        $this->hasMany('ControleAcessoLogs', [
            'foreignKey' => 'direcao_controladora_id',
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

        return $validator;
    }
}
