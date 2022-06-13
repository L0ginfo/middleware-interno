<?php


use Phinx\Seed\AbstractSeed;

class TipoPagamentos extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "Dinheiro",
            ),
            array(
                "id" => 2,
                "descricao" => "Cheque",
            ),
            array(
                "id" => 3,
                "descricao" => "Não Identificado",
            ),
            array(
                "id" => 4,
                "descricao" => "Codigo não encontrado",
            ),
        );
        
        $this->table('tipo_pagamentos')
            ->insert($data)
            ->save();
    }
}
