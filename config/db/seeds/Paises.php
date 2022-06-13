<?php


use Phinx\Seed\AbstractSeed;

class Paises extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Continentes'
        ];
    }
    
    public function run()
    {
        $data = [
            [
                'id'    => 1,
                'descricao'  => 'Brasil',
                'continente_id' => 1
            ]
        ];

        $table = $this->table('paises');
        $table->insert($data)->save();

    }
}
