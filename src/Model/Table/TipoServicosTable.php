<?php
namespace App\Model\Table;

use App\Model\Entity\TipoServico;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoServicos Model
 *
 * @property \Cake\ORM\Association\HasMany $LoteServicos
 */
class TipoServicosTable extends Table
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

        $this->table('tipo_servicos');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('LoteServicos', [
            'foreignKey' => 'tipo_servico_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('codigo');

        $validator
            ->requirePresence('nome', 'create')
            ->notEmpty('nome');

        $validator
            ->add('data_obrigatoria', 'valid', ['rule' => 'numeric'])
            ->requirePresence('data_obrigatoria', 'create')
            ->notEmpty('data_obrigatoria');

        return $validator;
    }
}
