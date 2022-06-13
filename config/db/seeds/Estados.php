<?php


use Phinx\Seed\AbstractSeed;

class Estados extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Regioes',
        ];
    }

    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "codigo_uf" => 12,
                "nome" => "Acre",
                "uf" => "AC",
                "regiao_id" => 1,
            ),
            array(
                "id" => 2,
                "codigo_uf" => 27,
                "nome" => "Alagoas",
                "uf" => "AL",
                "regiao_id" => 2,
            ),
            array(
                "id" => 3,
                "codigo_uf" => 16,
                "nome" => "Amapá",
                "uf" => "AP",
                "regiao_id" => 1,
            ),
            array(
                "id" => 4,
                "codigo_uf" => 13,
                "nome" => "Amazonas",
                "uf" => "AM",
                "regiao_id" => 1,
            ),
            array(
                "id" => 5,
                "codigo_uf" => 29,
                "nome" => "Bahia",
                "uf" => "BA",
                "regiao_id" => 2,
            ),
            array(
                "id" => 6,
                "codigo_uf" => 23,
                "nome" => "Ceará",
                "uf" => "CE",
                "regiao_id" => 2,
            ),
            array(
                "id" => 7,
                "codigo_uf" => 53,
                "nome" => "Distrito Federal",
                "uf" => "DF",
                "regiao_id" => 5,
            ),
            array(
                "id" => 8,
                "codigo_uf" => 32,
                "nome" => "Espírito Santo",
                "uf" => "ES",
                "regiao_id" => 3,
            ),
            array(
                "id" => 9,
                "codigo_uf" => 52,
                "nome" => "Goiás",
                "uf" => "GO",
                "regiao_id" => 5,
            ),
            array(
                "id" => 10,
                "codigo_uf" => 21,
                "nome" => "Maranhão",
                "uf" => "MA",
                "regiao_id" => 2,
            ),
            array(
                "id" => 11,
                "codigo_uf" => 51,
                "nome" => "Mato Grosso",
                "uf" => "MT",
                "regiao_id" => 5,
            ),
            array(
                "id" => 12,
                "codigo_uf" => 50,
                "nome" => "Mato Grosso do Sul",
                "uf" => "MS",
                "regiao_id" => 5,
            ),
            array(
                "id" => 13,
                "codigo_uf" => 31,
                "nome" => "Minas Gerais",
                "uf" => "MG",
                "regiao_id" => 3,
            ),
            array(
                "id" => 14,
                "codigo_uf" => 15,
                "nome" => "Pará",
                "uf" => "PA",
                "regiao_id" => 1,
            ),
            array(
                "id" => 15,
                "codigo_uf" => 25,
                "nome" => "Paraíba",
                "uf" => "PB",
                "regiao_id" => 2,
            ),
            array(
                "id" => 16,
                "codigo_uf" => 41,
                "nome" => "Paraná",
                "uf" => "PR",
                "regiao_id" => 4,
            ),
            array(
                "id" => 17,
                "codigo_uf" => 26,
                "nome" => "Pernambuco",
                "uf" => "PE",
                "regiao_id" => 2,
            ),
            array(
                "id" => 18,
                "codigo_uf" => 22,
                "nome" => "Piauí",
                "uf" => "PI",
                "regiao_id" => 2,
            ),
            array(
                "id" => 19,
                "codigo_uf" => 33,
                "nome" => "Rio de Janeiro",
                "uf" => "RJ",
                "regiao_id" => 3,
            ),
            array(
                "id" => 20,
                "codigo_uf" => 24,
                "nome" => "Rio Grande do Norte",
                "uf" => "RN",
                "regiao_id" => 2,
            ),
            array(
                "id" => 21,
                "codigo_uf" => 43,
                "nome" => "Rio Grande do Sul",
                "uf" => "RS",
                "regiao_id" => 4,
            ),
            array(
                "id" => 22,
                "codigo_uf" => 11,
                "nome" => "Rondônia",
                "uf" => "RO",
                "regiao_id" => 1,
            ),
            array(
                "id" => 23,
                "codigo_uf" => 14,
                "nome" => "Roraima",
                "uf" => "RR",
                "regiao_id" => 1,
            ),
            array(
                "id" => 24,
                "codigo_uf" => 42,
                "nome" => "Santa Catarina",
                "uf" => "SC",
                "regiao_id" => 4,
            ),
            array(
                "id" => 25,
                "codigo_uf" => 35,
                "nome" => "São Paulo",
                "uf" => "SP",
                "regiao_id" => 3,
            ),
            array(
                "id" => 26,
                "codigo_uf" => 28,
                "nome" => "Sergipe",
                "uf" => "SE",
                "regiao_id" => 2,
            ),
            array(
                "id" => 27,
                "codigo_uf" => 17,
                "nome" => "Tocantins",
                "uf" => "TO",
                "regiao_id" => 1,
            ),
        );

        $table = $this->table('estados');
        $table->insert($data)->save();

    }
}
