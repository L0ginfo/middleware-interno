<?php


use Phinx\Seed\AbstractSeed;

class SistemaCampos extends AbstractSeed
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
                "codigo" => "VALOR_CIF_MOEDA",
                "descricao" => "Valor informado",
            ),
            array(
                "id" => 2,
                "codigo" => "VALOR_FOB_MOEDA",
                "descricao" => "Valor informado",
            ),
            array(
                "id" => 3,
                "codigo" => "QUANTIDADE_TOTAL",
                "descricao" => "QUANTIDADE_TOTAL",
            ),
            array(
                "id" => 4,
                "codigo" => "PESO_BRUTO",
                "descricao" => "PESO_BRUTO",
            ),
            array(
                "id" => 5,
                "codigo" => "PESO_LIQUIDO",
                "descricao" => "PESO_LIQUIDO",
            ),
            array(
                "id" => 6,
                "codigo" => "RESULTADO_MOEDA_CIF",
                "descricao" => "Valor informado * moeda_cotacao",
            ),
            array(
                "id" => 7,
                "codigo" => "RESULTADO_MOEDA_FOB",
                "descricao" => "Valor informado * moeda_cotacao",
            ),
            array(
                "id" => 8,
                "codigo" => "SERVEXEC.QUANTIDADE",
                "descricao" => "SERVEXEC.QUANTIDADE",
            ),
        );        

        $this->table('sistema_campos')->insert($data)->save();
    }
}
