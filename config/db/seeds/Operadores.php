<?php


use Phinx\Seed\AbstractSeed;

class Operadores extends AbstractSeed
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
                "descricao" => "igual",
            ),
            array(
                "id" => 2,
                "descricao" => "diferente",
            ),
            array(
                "id" => 3,
                "descricao" => "menor",
            ),
            array(
                "id" => 4,
                "descricao" => "maior",
            ),
            array(
                "id" => 5,
                "descricao" => "entre",
            ),
            array(
                "id" => 6,
                "descricao" => "menor ou igual",
            ),
            array(
                "id" => 7,
                "descricao" => "maior ou igual",
            ),
            array(
                "id" => 8,
                "descricao" => "contem",
            ),
        );
        
        
        $table = $this->table('operadores');

        $table->insert($data)->save();

    }
}
