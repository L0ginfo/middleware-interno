<?php
namespace App\Model\Table;

use App\Model\Entity\Canal;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CanalTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('canal');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');
    }

}
