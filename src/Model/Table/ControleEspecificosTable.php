<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * ControleEspecificos Model
 *
 * @property \App\Model\Table\DocumentoMercadoriaItemControleEspecificosTable&\Cake\ORM\Association\HasMany $DocumentoMercadoriaItemControleEspecificos
 * @property \App\Model\Table\OrdemServicoCarregamentosTable&\Cake\ORM\Association\HasMany $OrdemServicoCarregamentos
 * @property \App\Model\Table\OrdemServicoItensTable&\Cake\ORM\Association\HasMany $OrdemServicoItens
 * @property \App\Model\Table\ProdutoControleEspecificosTable&\Cake\ORM\Association\HasMany $ProdutoControleEspecificos
 *
 * @method \App\Model\Entity\ControleEspecifico get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleEspecifico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleEspecifico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleEspecifico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleEspecifico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleEspecifico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleEspecifico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleEspecifico findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleEspecificosTable extends Table
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
        

        $this->setTable('controle_especificos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentoMercadoriaItemControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
        ]);
        $this->hasMany('OrdemServicoCarregamentos', [
            'foreignKey' => 'controle_especifico_id',
        ]);
        $this->hasMany('OrdemServicoItens', [
            'foreignKey' => 'controle_especifico_id',
        ]);
        $this->hasMany('ProdutoControleEspecificos', [
            'foreignKey' => 'controle_especifico_id',
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
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo')
            ->add('codigo', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Código ja existente.'
            ]);

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data)
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }
    }
}
