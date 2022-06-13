<?php
namespace App\Model\Table;

use App\Model\Entity\AutoGate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\LogComponent;

/**
 * AutoGate Model
 */
class AutoGateTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('auto_gate');
        $this->displayField('id');
        $this->primaryKey('id');
        
        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Agendamentos', [
            'foreignKey' => 'agendamento_id',
            'joinType' => 'INNER'
        ]);
    }
}