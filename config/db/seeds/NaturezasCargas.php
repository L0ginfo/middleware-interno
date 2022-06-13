<?php


use Phinx\Seed\AbstractSeed;

class NaturezasCargas extends AbstractSeed
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
                "descricao" => "NORMAL",
                "codigo" => "NOR",
            ),
            array(
                "id" => 2,
                "descricao" => "CARGA VALIOSA ",
                "codigo" => "VAL",
            ),
        );
        
        $table = $this->table('naturezas_cargas');
        $table->insert($data)->save();
        
    }
}
