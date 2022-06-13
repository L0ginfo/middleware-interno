<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoDocumentos Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\HasMany $DocumentosMercadorias
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\HasMany $DocumentosTransportes
 *
 * @method \App\Model\Entity\TipoDocumento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoDocumento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoDocumento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoDocumento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoDocumento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoDocumento findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoDocumentosTable extends Table
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

        $this->setTable('tipo_documentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'tipo_documento_id'
        ]);
        $this->hasMany('DocumentosTransportes', [
            'foreignKey' => 'tipo_documento_id'
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
            ->maxLength('descricao', 45)
            ->allowEmptyString('descricao');

        $validator
            ->scalar('tipo_documento')
            ->maxLength('tipo_documento', 10)
            ->requirePresence('tipo_documento', 'create')
            ->notEmptyString('tipo_documento');

        return $validator;
    }
}
