<?php
namespace App\Model\Table;

use App\Model\Entity\FaturamentoRegraEnvioEmail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\Component\ClonarComponent;

/**
 * FaturamentoRegra Model
 *
 */
class FaturamentoRegraEnvioEmailTable extends Table
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

        $this->table('faturamento_regra_envio_email');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('TipoEmpresas', [
            'foreignKey' => 'tipo_empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FaturamentoRegra', [
            'foreignKey' => 'faturamento_regra_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FaturamentoRegraEnvioEmailCondicao', [
            'foreignKey' => 'faturamento_regra_envio_email_condicao_id',
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
            ->requirePresence('tipo_empresa_id', 'create')
            ->notEmpty('tipo_empresa_id');

        $validator
            ->requirePresence('empresa_id', 'create')
            ->notEmpty('empresa_id');

        $validator
            ->requirePresence('faturamento_regra_id', 'create')
            ->notEmpty('faturamento_regra_id');

        $validator
            ->requirePresence('faturamento_regra_envio_email_condicao_id', 'create')
            ->notEmpty('faturamento_regra_envio_email_condicao_id');

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
        $rules->add($rules->existsIn(['tipo_empresa_id'], 'TipoEmpresas'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['faturamento_regra_id'], 'FaturamentoRegra'));
        return $rules;
    }

    public function afterSave($created) 
    {
        $this->clonar($created->data['entity']);
    }

    private function clonar($dados) 
    {
        $tabela = 'faturamento_regra_envio_email';
        $campos = ['id',
            'tipo_empresa_id',
            'empresa_id',
            'faturamento_regra_id',
            'faturamento_regra_envio_email_condicao_id',
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

    public function afterDelete($deletado)
    {
        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();
        if (@$deletado->data['entity']->id) {
            $sql = "DELETE faturamento_regra_envio_email WHERE id = " . $deletado->data['entity']->id;
        }
        $conn->query($sql);
    }
}
