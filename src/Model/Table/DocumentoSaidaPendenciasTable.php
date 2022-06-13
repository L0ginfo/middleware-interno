<?php

namespace App\Model\Table;

use App\Model\Entity\DocumentoSaidaPendencias;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PDO;
use PDOException;
use App\Controller\Component\ClonarComponent;

/**
 * DocumentoSaidaPendencias Model
 */
class DocumentoSaidaPendenciasTable extends Table
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

		$this->table('documento_saida_pendencias');
		$this->displayField('id');
        $this->primaryKey('id');
        
        $this->addBehavior('LogsTabelas');

		$this->belongsTo('DocumentoSaida', [
			'foreignKey' => 'documento_saida_id',
			'joinType' => 'INNER'
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
			->requirePresence('documento_saida_id', 'create')
			->notEmpty('documento_saida_id');

		$validator
			->requirePresence('tipo_pendencia', 'create')
			->notEmpty('tipo_pendencia');

		$validator
			->requirePresence('informacao', 'create')
			->notEmpty('informacao');

		return $validator;
	}

	/**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['documento_saida_id'], 'DocumentoSaida'));
        return $rules;
    }

    public function afterSave($created) 
    {
        $this->clonar($created->data['entity']);
    }

    /*
     * Metodo clonar()
     * @param $dados 
     *
     * Verifica os campos e salva na $tabela da base de dados Portal do SQLServer
     */
    private function clonar($dados) 
    {
        $tabela = 'documento_saida_pendencias';
        $campos = ['id',
            'documento_saida_id',
            'tipo_pendencia',
            'informacao',
        ];

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();
        $sql = "select count(*) as count from $tabela where id = " . $dados['id'];
        $existe = false;
        $res = $conn->query($sql);

        if (!$res) {
            return;
        }

        foreach (@$res as $i => $v) {
            if ($v['count'] > 0) {
                $existe = true;
            }
        }

        if ($existe) {
            $sql_campos = '';
            foreach ($campos as $i) {
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= " $i = '" . $dados[$i] . "' ";
            }
            $sql = "update $tabela set " . $sql_campos . ' where id = ' . $dados['id'];
            $conn->query($sql);
        } else {
            $sql_campos = '';
            $sql_valor = '';
            foreach ($campos as $i) {
                @$sql_valor .= (@$sql_valor ? ' , ' : '' );
                $sql_valor .= "'" . $dados[$i] . "' ";
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= $i;
            }
            $sql = "insert into $tabela  (" . $sql_campos . ' ) VALUES ( ' . $sql_valor . ")";
            $conn->query($sql);
        }
    }

    /*
     * Metodo afterDelete
     * @param $deletado
     *
     * Apos deletar do MySQL ele deleta do SQLServer tambem
     */
    public function afterDelete($deletado)
    {
        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        if (@$deletado->data['entity']->id) {
            $sql = "DELETE documento_saida_pendencias 
                    WHERE id = " . $deletado->data['entity']->id;
        }

        $conn->query($sql);
    }

}