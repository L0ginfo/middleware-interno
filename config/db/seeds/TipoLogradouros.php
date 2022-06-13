<?php


use Phinx\Seed\AbstractSeed;

class TipoLogradouros extends AbstractSeed
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
                "id" => 2,
                "sigla" => "AL",
                "descricao" => "Alameda",
            ),
            array(
                "id" => 3,
                "sigla" => "AC",
                "descricao" => "Acesso",
            ),
            array(
                "id" => 4,
                "sigla" => "AD",
                "descricao" => "Adro",
            ),
            array(
                "id" => 5,
                "sigla" => "ERA",
                "descricao" => "Aeroporto",
            ),
            array(
                "id" => 6,
                "sigla" => "AL",
                "descricao" => "Alameda",
            ),
            array(
                "id" => 7,
                "sigla" => "AT",
                "descricao" => "Alto",
            ),
            array(
                "id" => 8,
                "sigla" => "A",
                "descricao" => "Área",
            ),
            array(
                "id" => 9,
                "sigla" => "AE",
                "descricao" => "Área Especial",
            ),
            array(
                "id" => 10,
                "sigla" => "ART",
                "descricao" => "Artéria",
            ),
            array(
                "id" => 11,
                "sigla" => "ATL",
                "descricao" => "Atalho",
            ),
            array(
                "id" => 12,
                "sigla" => "AV",
                "descricao" => "Avenida",
            ),
            array(
                "id" => 13,
                "sigla" => "AV-CONT",
                "descricao" => "Avenida Contorno",
            ),
            array(
                "id" => 14,
                "sigla" => "BX",
                "descricao" => "Baixa",
            ),
            array(
                "id" => 15,
                "sigla" => "BLO",
                "descricao" => "Balão",
            ),
            array(
                "id" => 16,
                "sigla" => "BAL",
                "descricao" => "Balneário",
            ),
            array(
                "id" => 17,
                "sigla" => "BC",
                "descricao" => "Beco",
            ),
            array(
                "id" => 18,
                "sigla" => "BELV",
                "descricao" => "Belvedere",
            ),
            array(
                "id" => 19,
                "sigla" => "BL",
                "descricao" => "Bloco",
            ),
            array(
                "id" => 20,
                "sigla" => "BSQ",
                "descricao" => "Bosque",
            ),
            array(
                "id" => 21,
                "sigla" => "BVD",
                "descricao" => "Boulevard",
            ),
            array(
                "id" => 22,
                "sigla" => "BCO",
                "descricao" => "Buraco",
            ),
            array(
                "id" => 23,
                "sigla" => "C",
                "descricao" => "Cais",
            ),
            array(
                "id" => 24,
                "sigla" => "CALC",
                "descricao" => "Calçada",
            ),
            array(
                "id" => 25,
                "sigla" => "CAM",
                "descricao" => "Caminho",
            ),
            array(
                "id" => 26,
                "sigla" => "CPO",
                "descricao" => "Campo",
            ),
            array(
                "id" => 27,
                "sigla" => "CAN",
                "descricao" => "Canal",
            ),
            array(
                "id" => 28,
                "sigla" => "CH",
                "descricao" => "Chácara",
            ),
            array(
                "id" => 29,
                "sigla" => "CHAP",
                "descricao" => "Chapadão",
            ),
            array(
                "id" => 30,
                "sigla" => "CIRC",
                "descricao" => "Circular",
            ),
            array(
                "id" => 31,
                "sigla" => "COL",
                "descricao" => "Colônia",
            ),
            array(
                "id" => 32,
                "sigla" => "CMP-VR",
                "descricao" => "Complexo Viário",
            ),
            array(
                "id" => 33,
                "sigla" => "COND",
                "descricao" => "Condomínio",
            ),
            array(
                "id" => 34,
                "sigla" => "CJ",
                "descricao" => "Conjunto",
            ),
            array(
                "id" => 35,
                "sigla" => "COR",
                "descricao" => "Corredor",
            ),
            array(
                "id" => 36,
                "sigla" => "CRG",
                "descricao" => "Córrego",
            ),
            array(
                "id" => 37,
                "sigla" => "DSC",
                "descricao" => "Descida",
            ),
            array(
                "id" => 38,
                "sigla" => "DSV",
                "descricao" => "Desvio",
            ),
            array(
                "id" => 39,
                "sigla" => "DT",
                "descricao" => "Distrito",
            ),
            array(
                "id" => 40,
                "sigla" => "EVD",
                "descricao" => "Elevada",
            ),
            array(
                "id" => 41,
                "sigla" => "ENT-PART",
                "descricao" => "Entrada Particular",
            ),
            array(
                "id" => 42,
                "sigla" => "EQ",
                "descricao" => "Entre Quadra",
            ),
            array(
                "id" => 43,
                "sigla" => "ESC",
                "descricao" => "Escada",
            ),
            array(
                "id" => 44,
                "sigla" => "ESP",
                "descricao" => "Esplanada",
            ),
            array(
                "id" => 45,
                "sigla" => "ETC",
                "descricao" => "Estação",
            ),
            array(
                "id" => 46,
                "sigla" => "ESTC",
                "descricao" => "Estacionamento",
            ),
            array(
                "id" => 47,
                "sigla" => "ETD",
                "descricao" => "Estádio",
            ),
            array(
                "id" => 48,
                "sigla" => "ETN",
                "descricao" => "Estância",
            ),
            array(
                "id" => 49,
                "sigla" => "EST",
                "descricao" => "Estrada",
            ),
            array(
                "id" => 50,
                "sigla" => "EST-MUN",
                "descricao" => "Estrada Municipal",
            ),
            array(
                "id" => 51,
                "sigla" => "FAV",
                "descricao" => "Favela",
            ),
            array(
                "id" => 52,
                "sigla" => "FAZ",
                "descricao" => "Fazenda",
            ),
            array(
                "id" => 53,
                "sigla" => "FRA",
                "descricao" => "Feira",
            ),
            array(
                "id" => 54,
                "sigla" => "FER",
                "descricao" => "Ferrovia",
            ),
            array(
                "id" => 55,
                "sigla" => "FNT",
                "descricao" => "Fonte",
            ),
            array(
                "id" => 56,
                "sigla" => "FTE",
                "descricao" => "Forte",
            ),
            array(
                "id" => 57,
                "sigla" => "GAL",
                "descricao" => "Galeria",
            ),
            array(
                "id" => 58,
                "sigla" => "GJA",
                "descricao" => "Granja",
            ),
            array(
                "id" => 59,
                "sigla" => "HAB",
                "descricao" => "Habitacional",
            ),
            array(
                "id" => 60,
                "sigla" => "IA",
                "descricao" => "Ilha",
            ),
            array(
                "id" => 61,
                "sigla" => "JD",
                "descricao" => "Jardim",
            ),
            array(
                "id" => 62,
                "sigla" => "JDE",
                "descricao" => "Jardinete",
            ),
            array(
                "id" => 63,
                "sigla" => "LD",
                "descricao" => "Ladeira",
            ),
            array(
                "id" => 64,
                "sigla" => "LG",
                "descricao" => "Lago",
            ),
            array(
                "id" => 65,
                "sigla" => "LGA",
                "descricao" => "Lagoa",
            ),
            array(
                "id" => 66,
                "sigla" => "LRG",
                "descricao" => "Largo",
            ),
            array(
                "id" => 67,
                "sigla" => "LOT",
                "descricao" => "Loteamento",
            ),
            array(
                "id" => 68,
                "sigla" => "MNA",
                "descricao" => "Marina",
            ),
            array(
                "id" => 69,
                "sigla" => "MOD",
                "descricao" => "Módulo",
            ),
            array(
                "id" => 70,
                "sigla" => "TEM",
                "descricao" => "Monte",
            ),
            array(
                "id" => 71,
                "sigla" => "MRO",
                "descricao" => "Morro",
            ),
            array(
                "id" => 72,
                "sigla" => "NUC",
                "descricao" => "Núcleo",
            ),
            array(
                "id" => 73,
                "sigla" => "PDA",
                "descricao" => "Parada",
            ),
            array(
                "id" => 74,
                "sigla" => "PDO",
                "descricao" => "Paradouro",
            ),
            array(
                "id" => 75,
                "sigla" => "PAR",
                "descricao" => "Paralela",
            ),
            array(
                "id" => 76,
                "sigla" => "PRQ",
                "descricao" => "Parque",
            ),
            array(
                "id" => 77,
                "sigla" => "PSG",
                "descricao" => "Passagem",
            ),
            array(
                "id" => 78,
                "sigla" => "PSC-SUB",
                "descricao" => "Passagem Subterrânea",
            ),
            array(
                "id" => 79,
                "sigla" => "PSA",
                "descricao" => "Passarela",
            ),
            array(
                "id" => 80,
                "sigla" => "PAS",
                "descricao" => "Passeio",
            ),
            array(
                "id" => 81,
                "sigla" => "PAT",
                "descricao" => "Pátio",
            ),
            array(
                "id" => 82,
                "sigla" => "PNT",
                "descricao" => "Ponta",
            ),
            array(
                "id" => 83,
                "sigla" => "PTE",
                "descricao" => "Ponte",
            ),
            array(
                "id" => 84,
                "sigla" => "PTO",
                "descricao" => "Porto",
            ),
            array(
                "id" => 85,
                "sigla" => "PC",
                "descricao" => "Praça",
            ),
            array(
                "id" => 86,
                "sigla" => "PC-ESP",
                "descricao" => "Praça de Esportes",
            ),
            array(
                "id" => 87,
                "sigla" => "PR",
                "descricao" => "Praia",
            ),
            array(
                "id" => 88,
                "sigla" => "PRL",
                "descricao" => "Prolongamento",
            ),
            array(
                "id" => 89,
                "sigla" => "Q",
                "descricao" => "Quadra",
            ),
            array(
                "id" => 90,
                "sigla" => "QTA",
                "descricao" => "Quinta",
            ),
            array(
                "id" => 91,
                "sigla" => "QTASRodo",
                "descricao" => "Ane Quintas",
            ),
            array(
                "id" => 92,
                "sigla" => "RAM",
                "descricao" => "Ramal",
            ),
            array(
                "id" => 93,
                "sigla" => "RMP",
                "descricao" => "Rampa",
            ),
            array(
                "id" => 94,
                "sigla" => "REC",
                "descricao" => "Recanto",
            ),
            array(
                "id" => 95,
                "sigla" => "RES",
                "descricao" => "Residencial",
            ),
            array(
                "id" => 96,
                "sigla" => "RET",
                "descricao" => "Reta",
            ),
            array(
                "id" => 97,
                "sigla" => "RER",
                "descricao" => "Retiro",
            ),
            array(
                "id" => 98,
                "sigla" => "RTN",
                "descricao" => "Retorno",
            ),
            array(
                "id" => 99,
                "sigla" => "ROD-AN",
                "descricao" => "Rodo Anel",
            ),
            array(
                "id" => 100,
                "sigla" => "ROD",
                "descricao" => "Rodovia",
            ),
            array(
                "id" => 101,
                "sigla" => "RTT",
                "descricao" => "Rotatória",
            ),
            array(
                "id" => 102,
                "sigla" => "ROT",
                "descricao" => "Rótula",
            ),
            array(
                "id" => 103,
                "sigla" => "R",
                "descricao" => "Rua",
            ),
            array(
                "id" => 104,
                "sigla" => "R-LIG",
                "descricao" => "Rua de Ligação",
            ),
            array(
                "id" => 105,
                "sigla" => "R-PED",
                "descricao" => "Rua de Pedestre",
            ),
            array(
                "id" => 106,
                "sigla" => "SRV",
                "descricao" => "Servidão",
            ),
            array(
                "id" => 107,
                "sigla" => "ST",
                "descricao" => "Setor",
            ),
            array(
                "id" => 108,
                "sigla" => "SIT",
                "descricao" => "Sítio",
            ),
            array(
                "id" => 109,
                "sigla" => "SUB",
                "descricao" => "Subida",
            ),
            array(
                "id" => 110,
                "sigla" => "TER",
                "descricao" => "Terminal",
            ),
            array(
                "id" => 111,
                "sigla" => "TV",
                "descricao" => "Travessa",
            ),
            array(
                "id" => 112,
                "sigla" => "TV-PART",
                "descricao" => "Travessa Particular",
            ),
            array(
                "id" => 113,
                "sigla" => "TRC",
                "descricao" => "Trecho",
            ),
            array(
                "id" => 114,
                "sigla" => "TRV",
                "descricao" => "Trevo",
            ),
            array(
                "id" => 115,
                "sigla" => "TCH",
                "descricao" => "Trincheira",
            ),
            array(
                "id" => 116,
                "sigla" => "TUN",
                "descricao" => "Túnel",
            ),
            array(
                "id" => 117,
                "sigla" => "UNID",
                "descricao" => "Unidade",
            ),
            array(
                "id" => 118,
                "sigla" => "VAL",
                "descricao" => "Vala",
            ),
            array(
                "id" => 119,
                "sigla" => "VLE",
                "descricao" => "Vale",
            ),
            array(
                "id" => 120,
                "sigla" => "VRTE",
                "descricao" => "Variante",
            ),
            array(
                "id" => 121,
                "sigla" => "VER",
                "descricao" => "Vereda",
            ),
            array(
                "id" => 122,
                "sigla" => "V",
                "descricao" => "Via",
            ),
            array(
                "id" => 123,
                "sigla" => "V-AC",
                "descricao" => "AVia de Acesso",
            ),
            array(
                "id" => 124,
                "sigla" => "V-PED",
                "descricao" => "Via de Pedestre",
            ),
            array(
                "id" => 125,
                "sigla" => "V-EVD",
                "descricao" => "Via Elevado",
            ),
            array(
                "id" => 126,
                "sigla" => "V-EXP",
                "descricao" => "Via Expressa",
            ),
            array(
                "id" => 127,
                "sigla" => "VD",
                "descricao" => "Viaduto",
            ),
            array(
                "id" => 128,
                "sigla" => "VLA",
                "descricao" => "Viela",
            ),
            array(
                "id" => 129,
                "sigla" => "VL",
                "descricao" => "Vila",
            ),
            array(
                "id" => 130,
                "sigla" => "ZIG-ZAG",
                "descricao" => "Zigue-Zague",
            ),
        );
            
        $table = $this->table('tipo_logradouros');
        $table->insert($data)->save();
    }
}
