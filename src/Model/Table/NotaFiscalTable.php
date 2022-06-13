<?php

namespace App\Model\Table;

use App\Model\Entity\NotaFiscal;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * NotaFiscal Model
 */
class NotaFiscalTable extends Table
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

		$this->table('nota_fiscal');
		$this->displayField('id');
        $this->primaryKey('id');
        
        $this->addBehavior('LogsTabelas');

		$this->hasMany('NotaFiscalItem', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Empresas', [
			'foreignKey' => 'empresa_id',
			'joinType' => 'INNER'
		]);

		$this->hasOne('NotaFiscalAnexo', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Anexos', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('NotaFiscalChat', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('NotaFiscalPendencias', [
            'foreignKey' => 'nota_fiscal_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Embalagens', [
			'foreignKey' => 'embalagem_id',
			'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('Incoterme', [
			'foreignKey' => 'incoterme_id',
			'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('CodigoOnus', [
            'foreignKey' => 'codigo_onu_id',
            'joinType' => 'left'
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
            ->requirePresence('numero_documento', 'create')
            ->notEmpty('numero_documento');
        
        $validator
            ->requirePresence('modelo', 'create')
            ->notEmpty('modelo');

        $validator
            ->requirePresence('serie', 'create')
            ->notEmpty('serie');

        $validator
            ->requirePresence('data_emissao', 'create')
            ->notEmpty('data_emissao');

        $validator
            ->requirePresence('uf', 'create')
            ->notEmpty('uf');

        $validator
            ->requirePresence('empresa_id', 'create')
            ->notEmpty('empresa_id');

      /*  $validator
            ->requirePresence('nome_representante', 'create')
            ->notEmpty('nome_representante');

        $validator
            ->requirePresence('nome_despachante', 'create')
            ->notEmpty('nome_despachante');
        
        $validator
            ->requirePresence('nome_parceiro', 'create')
            ->notEmpty('nome_parceiro');*/

        $validator
            ->requirePresence('valor_total', 'create')
            ->notEmpty('valor_total');

        $validator
            ->requirePresence('numero_due', 'create')
            ->notEmpty('numero_due');

        $validator
            ->requirePresence('volume_total', 'create')
            ->notEmpty('volume_total');

        $validator
            ->requirePresence('peso_bruto', 'create')
            ->notEmpty('peso_bruto');

        $validator
            ->requirePresence('peso_liquido', 'create')
            ->notEmpty('peso_liquido');

        $validator
            ->requirePresence('embalagem_id', 'create')
            ->notEmpty('embalagem_id', 'Selecione uma embalagem');

        $validator
            ->requirePresence('incoterme_id', 'create')
            ->notEmpty('incoterme_id', 'Selecione uma embalagem');

        $validator
            ->requirePresence('anvisa', 'create')
            ->notEmpty('anvisa', 'Selecione uma opção');

        // $validator
        //     ->requirePresence('codigo_onu_id', 'create')
        //     ->notEmpty('codigo_onu_id', 'Selecione uma opção');
            
        return $validator;
	}

	/*
     * Metodo beforeFind()
     *
     * Executado toda vez que é chamado a model,
     * filtrando as NF-e de acordo com o perfil
     */
    function beforeFind(Event $event, Query $query, $options, $primary) 
    {
        $empresasUsuariosTable = TableRegistry::get('EmpresasUsuarios');
        $empresasUsuarios = $empresasUsuariosTable->find('all')->contain(['Empresas'])->where(['usuario_id' => $_SESSION['Auth']['User']['id']])->toArray();
        
        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_ADMIN) {
            return;
        } else {
            $list_cliente = '0';
            foreach ($empresasUsuarios as $e) {
                if ($e['perfil_id'] == PERFIL_CLIENTE) {
                    $list_cliente .= ",'" . $e['empresa']['id'] . "'";
                }
            }
            $conditions = $query->where('empresa_id in (' . $list_cliente . ')');
        }
    }

}