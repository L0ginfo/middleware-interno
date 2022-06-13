<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class DocumentoSaida extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
