<?php


use Phinx\Seed\AbstractSeed;

class FormaPagamentos extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "CORRENTISTA",
            ),
            array(
                "id" => 2,
                "descricao" => "À VISTA",
            ),
        );
        
        $table = $this->table('forma_pagamentos');
        $table->insert($data)->save();

    }
}
