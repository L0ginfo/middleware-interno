<?php


use Phinx\Seed\AbstractSeed;

class Empresas extends AbstractSeed
{

    public function getDependencies()
    {
        return [
            'Cidades',
            'TiposEmpresas',
            'TipoServicoBancarios',
            'Logradouros'
        ];
    }

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $empresas = array(
            array(
                "codigo" => "01",
                "numero" => "100",
                'endereco'=>'hsahsa',
                'cidade'=>'hsahsa',
                'bairro'=>'sasa',
                'cep'=>'sasa',
                'uf_id'=>1,
                "descricao" => "Jonville - SC",
                "cnpj" => "0",
                "logradouro_id"=> 1,
                "ra_codigo" => "SC",
                "tipos_empresa_id" => 1,
                "tipo_servico_bancario_id"=>1,
                "telefone" => "999999999",
                "email"=>"dhgsdg@sajsja"
            ),
            array(
                "codigo" => "81",
                "numero" => "100",
                'endereco'=>'hsahsa',
                'cidade'=>'hsahsa',
                'bairro'=>'sasa',
                'uf_id'=> 1,
                'cep'=>'sasa',
                "descricao" => "BMW",
                "cnpj" => "1",
                "logradouro_id"=> 1,
                "ra_codigo" => "SC",
                "tipos_empresa_id" => 2,
                "tipo_servico_bancario_id"=>1,
                "telefone" => "999999999",
                "email"=>"dhgsdg@sajsja"
            ),
        );

        $this->table('empresas')->insert($empresas)->save();

    }
}
