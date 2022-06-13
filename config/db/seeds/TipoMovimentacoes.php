<?php


use Phinx\Seed\AbstractSeed;

class TipoMovimentacoes extends AbstractSeed
{

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'descricao' => 'CARGA - SAIDA',
            ],
            [
                'id' => 2,
                'descricao' => 'DESCARGA - ENTRADA',
            ],
            [
                'id' => 3,
                'descricao' => 'MOV',
            ],
            [
                "id" => 4,
                "descricao"  => "PICKING - SEPARAÇÃO"
            ],
            [
                "id" => 5,
                "descricao"  => "PICKING - ESTORNO"
            ],
            [
                "id" => 6,
                "descricao"  => "IMPORTAÇÃO ESTOQUE"
            ],
            [
                "id" => 7,
                "descricao"  => "INVENTÁRIO"
            ],
            [
                "id" => 8,
                "descricao"  => "DESCARGA - ESTORNO"
            ],
            [
                "id" => 9,
                "descricao"  => "CARGA - ESTORNO"
            ],
            [
                'id' => 10,
                'descricao'  => 'RESERVA - ENTRADA'
            ],
            [
                'id' => 11,
                'descricao'  => 'RESERVA - SAIDA'
            ],
            [
                'id' => 12,
                'descricao'  => 'POSIÇÃO ESTOQUE'
            ]
        ];
        
        $table = $this->table('tipo_movimentacoes');
        $table->insert($data)->save();

    }
}
