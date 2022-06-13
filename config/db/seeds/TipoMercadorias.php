<?php


use Phinx\Seed\AbstractSeed;

class TipoMercadorias extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "master que não vai desconsolidar (master puro)",
                "codigo" => "01",
            ),
            array(
                "id" => 2,
                "descricao" => "master que vai desconsolidar",
                "codigo" => "02",
            ),
            array(
                "id" => 3,
                "descricao" => "master com houses (normal)",
                "codigo" => "03",
            ),
        );

        $table = $this->table('tipo_mercadorias');
        $table->insert($data)->save();

    }
}
