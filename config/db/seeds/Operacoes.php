<?php


use Phinx\Seed\AbstractSeed;

class Operacoes extends AbstractSeed
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
                "descricao" => "Descarga",
            ),
            array(
                "id" => 2,
                "descricao" => "Carga",
            ),
        );

        $table = $this->table('operacoes');
        $table->insert($data)->save();
        
    }
}
