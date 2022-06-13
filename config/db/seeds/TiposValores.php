<?php


use Phinx\Seed\AbstractSeed;

class TiposValores extends AbstractSeed
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
                "descricao" => "VALOR",
                "formula" => NULL,
            ),
            array(
                "id" => 2,
                "descricao" => "TAXA",
                "formula" => NULL,
            ),
        );
        
        $this->table('tipos_valores')->insert($data)->save();
        
    }
}
