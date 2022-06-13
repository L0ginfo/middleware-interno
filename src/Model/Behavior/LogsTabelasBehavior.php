<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Model\Entity\LogsTabela;

/**
 * Log behaviors
 */

class LogsTabelasBehavior extends Behavior
{
    public function afterSave($event, $entity, $options)
    {
        LogsTabela::saveLog($entity);
    }

    public function afterDelete($event, $entity, $options)
    {
        LogsTabela::deleteLog($entity);
    }
}
