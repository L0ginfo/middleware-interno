<?php


use Phinx\Seed\AbstractSeed;

class EmpresaFormaPagamentos extends AbstractSeed
{
    
    public function getDependencies()
    {
        return [
            'Empresas',
            'FormaPagamentos',
        ];
    }

    public function run()
    {

        $data = array(
            array(
                "id" => 1,
                "destino" => "faturamento",
                "cliente_id" => 2,
                "forma_pagamento_id" => 2,
            ),
        );
        
        $this->table('empresa_forma_pagamentos')
            ->insert($data)->save();

    }
}
