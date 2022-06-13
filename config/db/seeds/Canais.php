<?php


use Phinx\Seed\AbstractSeed;

class Canais extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'id' => 0,
                'descricao' => 'VERDE'
            ],
            [
                'id' => 0,
                'descricao' => 'AMARELO'
            ],
            [
                'id' => 0,
                'descricao' => 'VERMELHO'
            ],
            [
                'id' => 0,
                'descricao' => 'CINZA'
            ]
        ];
        
        $table = $this->table('canais');
        $table->insert($data)->save();

    }
}
