<?php


use Phinx\Seed\AbstractSeed;

class TiposFaturamentos extends AbstractSeed
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
                "id" => 2,
                "descricao" => "DAI",
            ),
            array(
                "id" => 1,
                "descricao" => "DAE",
            ),
            array(
                "id" => 3,
                "descricao" => "DAPE",
            )
        );
        
        $this->table('tipos_faturamentos')->insert($data)->save();
    }
}
