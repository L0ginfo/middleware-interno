<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlanoDesovaContainersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->addBehavior('LogsTabelas');
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->container_id) {
            $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($entity->container_id);
            $entity->entrada_saida_container_id = @$oEntradaSaidaContainers->id;
        }
    }
}
