<?php


use Phinx\Seed\AbstractSeed;

class Avarias extends AbstractSeed
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
                "codigo" => "A",
                "descricao" => "Diferença de Peso",
            ),
            array(
                "codigo" => "B",
                "descricao" => "Lacre Violado",
            ),
            array(
                "codigo" => "C",
                "descricao" => "Amassado",
            ),
            array(
                "codigo" => "D",
                "descricao" => "Vazamento",
            ),
            array(
                "codigo" => "E",
                "descricao" => "Quebrado",
            ),
            array(
                "codigo" => "F",
                "descricao" => "Rasgado",
            ),
            array(
                "codigo" => "G",
                "descricao" => "Refitado",
            ),
            array(
                "codigo" => "H",
                "descricao" => "Furado",
            ),
            array(
                "codigo" => "I",
                "descricao" => "Aberto",
            ),
            array(
                "codigo" => "J",
                "descricao" => "Molhado",
            ),
            array(
                "codigo" => "K",
                "descricao" => "Despregado",
            ),
            array(
                "codigo" => "L",
                "descricao" => "Repregado",
            ),
            array(
                "codigo" => "M",
                "descricao" => "Indícios de Violação",
            ),
            array(
                "codigo" => "N",
                "descricao" => "Riscado",
            ),
            array(
                "codigo" => "O",
                "descricao" => "Sensor de Impacto Ativado",
            ),
            array(
                "codigo" => "P",
                "descricao" => "Sensor de Inclinação Ativado",
            ),
            array(
                "codigo" => "Q",
                "descricao" => "Carga Recebida com Alteração de Informação",
            ),
            array(
                "codigo" => "R",
                "descricao" => "Indícios de Deterioração",
            ),
            array(
                "codigo" => "S",
                "descricao" => "Carga Lacrada Pelo Fiel Depositário",
            ),
        );
        
        $table = $this->table('avarias');

        $table->insert($data)->save();
    }
}
