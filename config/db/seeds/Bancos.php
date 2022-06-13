<?php


use Phinx\Seed\AbstractSeed;

class Bancos extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 0,
                "nome" => "Banco do Brasil",
                "descricao" => "Banco do Brasil",
                "codigo" => "001",
            ),
            array(
                "id" => 0,
                "nome" => "Bradesco",
                "descricao" => "Bradesco",
                "codigo" => "237",
            ),
        );
        
        $table = $this->table('bancos');
        $table->insert($data)->save();
    }
}
