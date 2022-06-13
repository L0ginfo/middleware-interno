<?php


use Phinx\Seed\AbstractSeed;

class TratamentosCargas extends AbstractSeed
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
                "descricao" => "LIBERACAO IMEDIATA",
                "codigo" => "TC1",
            ),
            array(
                "id" => 2,
                "descricao" => "TRANSITO RODOVIARIO IMEDIATO",
                "codigo" => "TC2",
            ),
        );

        $table = $this->table('tratamentos_cargas');
        $table->insert($data)->save();

    }
}
