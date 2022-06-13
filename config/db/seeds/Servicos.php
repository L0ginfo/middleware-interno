<?php


use Phinx\Seed\AbstractSeed;

class Servicos extends AbstractSeed
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
                "descricao" => "Armazenar Entradas Físicas",
            ),
            array(
                "id" => 2,
                "descricao" => "THC",
            ),
            array(
                "id" => 3,
                "descricao" => "Outros",
            )
        );

        $this->table('servicos')->insert($data)->save();

    }
}
