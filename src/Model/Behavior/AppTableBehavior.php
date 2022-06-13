<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;

class AppTableBehavior extends Behavior
{

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        debug($event);
        debug($data);
        debug($options);
        die();
    }
    
    

}
