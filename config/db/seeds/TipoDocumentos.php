<?php


use Phinx\Seed\AbstractSeed;

class TipoDocumentos extends AbstractSeed
{
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
        $data = array(
            array(
                "id" => 0,
                "descricao" => "TERMO",
                "tipo_documento" => "TERMO",
            ),
            array(
                "id" => 0,
                "descricao" => "AWB",
                "tipo_documento" => "AWB",
            ),
            array(
                "id" => 0,
                "descricao" => "HAWB",
                "tipo_documento" => "HAWB",
            ),
            array(
                "id" => 0,
                "descricao" => "DI",
                "tipo_documento" => "DI",
            ),
            array(
                "id" => 0,
                "descricao" => "DUE",
                "tipo_documento" => "DUE",
            ),
            array(
                "id" => 0,
                "descricao" => "NF",
                "tipo_documento" => "NF",
            )
        );

        $this->table('tipo_documentos')->insert($data)->save();
        
    }
}
