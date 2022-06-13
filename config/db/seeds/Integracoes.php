<?php


use Phinx\Seed\AbstractSeed;

class Integracoes extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                "id" => 1,
                "nome" => "Produtos/Estoques",
                "descricao" => "Integra os Produtos/Estoque",
                "codigo_unico" => "produtos-estoques",
                "json_header" => "\"{\\r\\n    \\\"x-api-key\\\": \\\"A8B91024C34A60CB618930660CB5A31332F95262B543E61565237530\\\",\\r\\n    \\\"content-type\\\": \\\"application/json\\\"\\r\\n}\"",
                "url_endpoint" => "http://bertointl.ddns.net:59236/datasnap/rest/TWSZadaEdiMetodos/ListaProdutos",
                "ativo" => 1,
                "gravar_log" => 1,
                "private_key" => "4c607e8ac6d04fa58378d4c5ce1df2befd32e60b",
                "data_integracao" => NULL,
                "tipo" => "API",
                "db_host" => NULL,
                "db_porta" => NULL,
                "db_database" => NULL,
                "db_user" => NULL,
                "db_pass" => NULL,
            ],
            [
                "id" => 2,
                "nome" => "Pedidos",
                "descricao" => "Integra os pedidos",
                "codigo_unico" => "pedidos",
                "json_header" => "\"{\\r\\n    \\\"x-api-key\\\": \\\"A8B91024C34A60CB618930660CB5A31332F95262B543E61565237530\\\",\\r\\n    \\\"content-type\\\": \\\"application/json\\\"\\r\\n}\"",
                "url_endpoint" => "http://bertointl.ddns.net:59236/datasnap/rest/TWSZadaEdiMetodos/Pedidos",
                "ativo" => 1,
                "gravar_log" => 1,
                "private_key" => "4c607e8ac6d04fa58378d4c5ce1df2befd32e60b",
                "data_integracao" => NULL,
                "tipo" => "API",
                "db_host" => NULL,
                "db_porta" => NULL,
                "db_database" => NULL,
                "db_user" => NULL,
                "db_pass" => NULL,
            ]
        ];

        $table = $this->table('integracoes');
        $table->insert($data)->save();
    }
}
