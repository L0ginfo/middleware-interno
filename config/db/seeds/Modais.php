<?php


use Phinx\Seed\AbstractSeed;

class Modais extends AbstractSeed
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
                "descricao" => "Áereo",
            ),
            array(
                "id" => 2,
                "descricao" => "Rodoviário",
            ),
            array(
                "id" => 3,
                "descricao" => "Marítimo",
            ),
            array(
                "id" => 4,
                "descricao" => "Ferroviário ",
            ),
        );
        
        
        $table = $this->table('modais');
        $table->insert($data)->save();
    }
}
