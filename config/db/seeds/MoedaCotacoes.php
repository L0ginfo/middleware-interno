<?php


use Phinx\Seed\AbstractSeed;

class MoedaCotacoes extends AbstractSeed
{
    
    public function getDependencies()
    {
        return [
            'Moedas',
        ];
    }

    public function run()
    {
        $data = array(
            array(
                "id" => 0,
                "tipo_cotacao" => "normal",
                "data_cotacao" => date('Y-m-d'),
                "valor_cotacao" => 4.000,
                "moeda_id" => 1,
            ),
        );        
        
        $table = $this->table('moedas_cotacoes');
        $table->insert($data)->save();

    }
}
