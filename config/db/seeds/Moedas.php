<?php


use Phinx\Seed\AbstractSeed;

class Moedas extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'descricao' => 'DOLAR',
                'sigla' => 'US'
            ],
            [
                'id' => 2,
                'descricao' => 'REAL',
                'sigla' => 'BRL'
            ],
            [
                'id' => 3,
                'descricao' => 'EURO',
                'sigla' => 'EUR'
            ]
        ];
        
        $table = $this->table('moedas');
        $table->insert($data)->save();

    }
}
