<?php


use Phinx\Seed\AbstractSeed;

class UnidadeMedidas extends AbstractSeed
{
    
    public function getDependencies()
    {
        return [
            'Empresas',
        ];
    }

    public function run()
    {

        $data = array(
            array(
                "id" => 1,
                "descricao" => "Tambor de Plástico",
                "codigo" => "01",
                "empresa_id" => 1,
            ),
            array(
                "id" => 2,
                "descricao" => "Tambor de Metal",
                "codigo" => "02",
                "empresa_id" => 1,
            ),
            array(
                "id" => 3,
                "descricao" => "Tambor de Papel",
                "codigo" => "03",
                "empresa_id" => 1,
            ),
            array(
                "id" => 4,
                "descricao" => "Caixa de Madeira",
                "codigo" => "04",
                "empresa_id" => 1,
            ),
            array(
                "id" => 5,
                "descricao" => "Caixa de Papelão",
                "codigo" => "05",
                "empresa_id" => 1,
            ),
            array(
                "id" => 6,
                "descricao" => "Caixa de Isopor",
                "codigo" => "06",
                "empresa_id" => 1,
            ),
            array(
                "id" => 7,
                "descricao" => "Saco Plástico",
                "codigo" => "07",
                "empresa_id" => 1,
            ),
            array(
                "id" => 8,
                "descricao" => "Saco de Aniagem",
                "codigo" => "08",
                "empresa_id" => 1,
            ),
            array(
                "id" => 9,
                "descricao" => "Amarrado",
                "codigo" => "09",
                "empresa_id" => 1,
            ),
            array(
                "id" => 10,
                "descricao" => "Envelope",
                "codigo" => "10",
                "empresa_id" => 1,
            ),
            array(
                "id" => 11,
                "descricao" => "Pacote",
                "codigo" => "11",
                "empresa_id" => 1,
            ),
            array(
                "id" => 12,
                "descricao" => "Peça",
                "codigo" => "12",
                "empresa_id" => 1,
            ),
            array(
                "id" => 13,
                "descricao" => "Canudo",
                "codigo" => "13",
                "empresa_id" => 1,
            ),
            array(
                "id" => 14,
                "descricao" => "Engradado",
                "codigo" => "14",
                "empresa_id" => 1,
            ),
            array(
                "id" => 15,
                "descricao" => "Mala Normal",
                "codigo" => "15",
                "empresa_id" => 1,
            ),
            array(
                "id" => 16,
                "descricao" => "Mala Diplomática",
                "codigo" => "16",
                "empresa_id" => 1,
            ),
            array(
                "id" => 17,
                "descricao" => "Urna Funerária",
                "codigo" => "17",
                "empresa_id" => 1,
            ),
            array(
                "id" => 18,
                "descricao" => "Caixa de Metal",
                "codigo" => "18",
                "empresa_id" => 1,
            ),
            array(
                "id" => 19,
                "descricao" => "Baú de Metal",
                "codigo" => "19",
                "empresa_id" => 1,
            ),
            array(
                "id" => 20,
                "descricao" => "Baú de Madeira",
                "codigo" => "20",
                "empresa_id" => 1,
            ),
            array(
                "id" => 21,
                "descricao" => "Light-van",
                "codigo" => "21",
                "empresa_id" => 1,
            ),
            array(
                "id" => 22,
                "descricao" => "Container",
                "codigo" => "22",
                "empresa_id" => 1,
            ),
            array(
                "id" => 23,
                "descricao" => "Caixa de Papelão",
                "codigo" => "23",
                "empresa_id" => 1,
            ),
            array(
                "id" => 24,
                "descricao" => "Saco de Lona",
                "codigo" => "24",
                "empresa_id" => 1,
            ),
            array(
                "id" => 25,
                "descricao" => "Diversos",
                "codigo" => "25",
                "empresa_id" => 1,
            )
        );

        $table = $this->table('unidade_medidas');
        $table->insert($data)->save();
    }
}
