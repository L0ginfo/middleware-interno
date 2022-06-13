<?php


use Phinx\Seed\AbstractSeed;

class Regioes extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Paises'
        ];
    }

    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "nome" => "Norte",
            ),
            array(
                "id" => 2,
                "nome" => "Nordeste",
            ),
            array(
                "id" => 3,
                "nome" => "Sudeste",
            ),
            array(
                "id" => 4,
                "nome" => "Sul",
            ),
            array(
                "id" => 5,
                "nome" => "Centro-Oeste",
            ),
        );

        $table = $this->table('regioes');
        $table->insert($data)->save();
    }
}
