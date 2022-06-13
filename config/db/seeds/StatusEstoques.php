<?php


use Phinx\Seed\AbstractSeed;

class StatusEstoques extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                "id" => 1,
                "descricao"  => "OK"
            ],
            [
                "id" => 2,
                "descricao"  => "AVARIADO"
            ],
            [
                "id" => 3,
                "descricao"  => "BLOQUEADO"
            ],
            [
                "id" => 4,
                "descricao"  => "SILO"
            ]
        ];

        $table = $this->table('status_estoques');
        $table->insert($data)->save();
    }
}
