<?php


use Phinx\Seed\AbstractSeed;

class TipoServicoBancarios extends AbstractSeed
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
                "codigo" => "N",
                "descricao" => "À VISTA",
            ),
            array(
                "codigo" => "C",
                "descricao" => "CORRENTISTA",
            )
        );
        
        $table = $this->table('tipo_servico_bancarios');

        $table->insert($data)->save();
    }
}
