<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AutoGate extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    const STATUS_DENTRO = 1;
    const STATUS_FORA = 2;
    
    public function mensagem_status ($id) 
    {
        if ($id == self::STATUS_FORA) {
            $mensagem = "Fora do recinto";
        } elseif ($id == self::STATUS_DENTRO) {
            $mensagem = "Dentro do recinto";
        }

        return $mensagem;
    }
}
