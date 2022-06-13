<?php
namespace App\Model\Table;

use App\Model\Entity\FaturamentoRegraEnvioEmailCondicao;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Controller\Component\ClonarComponent;

/**
 * FaturamentoRegra Model
 *
 */
class FaturamentoRegraEnvioEmailCondicaoTable extends Table
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

        $this->table('faturamento_regra_envio_email_condicao');
        $this->displayField('descricao');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

    }

}
