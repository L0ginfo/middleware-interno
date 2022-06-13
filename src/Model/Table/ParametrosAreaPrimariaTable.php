<?php 

namespace App\Model\Table;

use App\Model\Entity\ParametrosAreaPrimaria;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;

class ParametrosAreaPrimariaTable extends Table
{
	public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('parametros_area_primaria');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Recintos', [
            'foreignKey' => 'recinto_id'
        ]);

        $this->addBehavior('LogsTabelas');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->notEmpty('percentual_sobre_cif');

        $validator
            ->allowEmpty('levante');

        $validator
            ->allowEmpty('pesagem');

        $validator
            ->allowEmpty('segregacao');

        $validator
            ->allowEmpty('excesso_percentual_sobre_cif');

        $validator
            ->allowEmpty('excesso_levante');

        $validator
            ->allowEmpty('excesso_pesagem');

        $validator
            ->allowEmpty('excesso_segregacao');

        $validator
            ->allowEmpty('container');

        $validator->add('percentual_sobre_cif', [
            'validaMaiorZero' => [
                'rule' => 'validaMaiorZero',
                'provider' => 'table',
                'message' => 'Valor inválido'
            ]
        ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['recinto_id']));
        return $rules;
    }

    public function validaMaiorZero($check, $context) 
    {
        $valor = str_replace('.', '', $check);
        $valor = str_replace(',', '.', $valor);

        if ($valor > 0)
            return true;
        else  
            return false;
    }
    
}