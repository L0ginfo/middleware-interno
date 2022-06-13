<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoAcessos Model
 *
 * @property \App\Model\Table\ControleAcessoCodigosTable&\Cake\ORM\Association\HasMany $ControleAcessoCodigos
 * @property \App\Model\Table\ControleAcessoLogsTable&\Cake\ORM\Association\HasMany $ControleAcessoLogs
 * @property \App\Model\Table\CredenciamentoPerfisTable&\Cake\ORM\Association\HasMany $CredenciamentoPerfis
 *
 * @method \App\Model\Entity\TipoAcesso get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoAcesso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoAcesso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoAcesso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoAcesso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoAcesso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoAcesso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoAcesso findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoAcessosTable extends Table
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
        

        $this->setTable('tipo_acessos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('ControleAcessoCodigos', [
            'foreignKey' => 'tipo_acesso_id',
        ]);
        $this->hasMany('ControleAcessoLogs', [
            'foreignKey' => 'tipo_acesso_id',
        ]);
        $this->hasMany('CredenciamentoPerfis', [
            'foreignKey' => 'tipo_acesso_id',
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
