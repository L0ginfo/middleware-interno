<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaItens Model
 *
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\BelongsTo $Vistorias
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\VistoriaAvariasTable&\Cake\ORM\Association\HasMany $VistoriaAvarias
 *
 * @method \App\Model\Entity\VistoriaItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaItem findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaItensTable extends Table
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
        

        $this->setTable('vistoria_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Vistorias', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('VistoriaAvarias', [
            'foreignKey' => 'vistoria_item_id',
        ]);
        $this->belongsTo('ContainerFormaUsos', [
            'foreignKey' => 'container_forma_uso_id',
        ]);
        $this->belongsTo('Produtos', [
            'foreignKey' => 'produto_id',
        ]);
        $this->belongsTo('Enderecos', [
            'foreignKey' => 'endereco_id',
        ]);
        $this->hasMany('VistoriaFotos', [
            'foreignKey' => 'vistoria_item_id',
            'joinType'   => 'LEFT'
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasItens', [
            'foreignKey' => 'documento_mercadoria_item_id',
        ]);
        $this->hasMany('VistoriaLacres', [
            'foreignKey' => 'vistoria_item_id',
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
            ->decimal('tara')
            ->allowEmptyString('tara');

        $validator
            ->decimal('mgw')
            ->allowEmptyString('mgw');

        $validator
            ->scalar('tipo_iso')
            ->maxLength('tipo_iso', 255)
            ->allowEmptyString('tipo_iso');

        $validator
            ->dateTime('data_hora_vistoria')
            ->allowEmptyDateTime('data_hora_vistoria');

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
        $rules->add($rules->existsIn(['vistoria_id'], 'Vistorias'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id, false, false, true);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
