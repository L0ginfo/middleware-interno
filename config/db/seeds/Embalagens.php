<?php


use Phinx\Seed\AbstractSeed;

class Embalagens extends AbstractSeed
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
                "codigo" => "01",
                "descricao" => "Tambor de Plástico NGJ = Carga perigosa em pequenas quantidades",
            ),
            array(
                "codigo" => "02",
                "descricao" => "Tambor de Metal NOR = Normal",
            ),
            array(
                "codigo" => "03",
                "descricao" => "Tambor de Papel PEA = Perecível entre -18° e 0°",
            ),
            array(
                "codigo" => "04",
                "descricao" => "Caixa de Madeira PEB = Perecível entre 2° e 8°",
            ),
            array(
                "codigo" => "05",
                "descricao" => "Caixa de Papelão PEC = Perecível entre 9° e 15°",
            ),
            array(
                "codigo" => "06",
                "descricao" => "Caixa de Isopor PED = Perecível entre 16° e 22°",
            ),
            array(
                "codigo" => "07",
                "descricao" => "Saco Plástico PEE = Perecível em condições especiais",
            ),
            array(
                "codigo" => "08",
                "descricao" => "Saco de Aniagem PLS = Plantas e Sementes",
            ),
            array(
                "codigo" => "09",
                "descricao" => "Amarrado RPG = Gás venenoso",
            ),
            array(
                "codigo" => "10",
                "descricao" => "Envelope RPW = Material Radioativo - Categoria I",
            ),
            array(
                "codigo" => "11",
                "descricao" => "Pacote RRW = Material Radioativo - Categoria II",
            ),
            array(
                "codigo" => "12",
                "descricao" => "Peça RXD = Explosivos (1.4D)",
            ),
            array(
                "codigo" => "13",
                "descricao" => "Canudo RXE = Explosivos (1.4E)",
            ),
            array(
                "codigo" => "14",
                "descricao" => "Engradado RXG = Explosivos (1.4G)",
            ),
            array(
                "codigo" => "15",
                "descricao" => "Mala Normal RXS = Explosivos (1.4S)",
            ),
            array(
                "codigo" => "16",
                "descricao" => "Mala Diplomática SAL = Correio Terrestre",
            ),
            array(
                "codigo" => "17",
                "descricao" => "Urna Funerária VAL = Carga Valiosa",
            ),
            array(
                "codigo" => "18",
                "descricao" => "Caixa de Metal VOL = Carga Volumétrica ou de Volume",
            ),
            array(
                "codigo" => "19",
                "descricao" => "Baú de Metal ATT = Cargas relacionadas no AWB",
            ),
            array(
                "codigo" => "20",
                "descricao" => "Baú de Madeira",
            ),
            array(
                "codigo" => "21",
                "descricao" => "Light-van",
            ),
            array(
                "codigo" => "22",
                "descricao" => "Container",
            ),
            array(
                "codigo" => "23",
                "descricao" => "Caixa de Papelão",
            ),
            array(
                "codigo" => "24",
                "descricao" => "Saco de Lona",
            ),
            array(
                "codigo" => "25",
                "descricao" => "Diversos",
            ),
        );
        

        $table = $this->table('embalagens');
        $table->insert($data)->save();

    }
}
