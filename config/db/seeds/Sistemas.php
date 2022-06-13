<?php

use Phinx\Seed\AbstractSeed;

class Sistemas extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id'    => 1,
                'nome'  => 'Credenciamento',
                'ativo' => true
            ],
            [
                'id'    => 2,
                'nome'  => 'WMS',
                'ativo' => true,
                'sem_registro' => 'Não cadastrado.'
            ]
        ];

        $table = $this->table('sistemas');
        $table->insert($data)->save();
    }
}
