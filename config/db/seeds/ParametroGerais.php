<?php


use Phinx\Seed\AbstractSeed;

class ParametroGerais extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "Parâmetro utilizado para informar a quantidades de dias padrão para gerar o faturamento futuro.",
                "nome_unico" => "QTD_PERIODOS_GERAR_FATU",
                "valor" => "8",
                'empresa_id' => 1,
            ),
            array(
                "id" => 2,
                "descricao" => "FATURAMENTO CODIGO DE BARRAS\r\n\r\nIdentificação do Produto",
                "nome_unico" => "FATU_COD_BARRA_IDEN_PRODUTO",
                "valor" => "8",
                'empresa_id' => 1,
            ),
            array(
                "id" => 3,
                "descricao" => "FATURAMENTO CODIGO DE BARRAS\r\n\r\nIdentificação do Segmento",
                "nome_unico" => "FATU_COD_BARRA_IDEN_SEGMENTO",
                "valor" => "6",
                'empresa_id' => 1,
            ),
            array(
                "id" => 4,
                "descricao" => "FATURAMENTO CODIGO DE BARRAS\r\n\r\nIdentificação do valor real ou referência",
                "nome_unico" => "FATU_COD_BARRA_IDEN_VALOR_REAL_REF",
                "valor" => "7",
                'empresa_id' => 1,
            ),
            array(
                "id" => 5,
                "descricao" => "AGENCIA_UNIDADE_PTN",
                "nome_unico" => "AGENCIA_UNIDADE_PTN",
                "valor" => "2368",
                'empresa_id' => 1,
            ),
            array(
                "id" => 6,
                "descricao" => "CONTA_CORRENTE_UNIDADE_PTN",
                "nome_unico" => "CONTA_CORRENTE_UNIDADE_PTN",
                "valor" => "0000663-7",
                'empresa_id' => 1,
            ),
            array(
                "id" => 7,
                "descricao" => "DESCRICAO_BOLETO_DAPE_UNIDADE_PTN",
                "nome_unico" => "DESCRICAO_BOLETO_DAPE_UNIDADE_PTN",
                "valor" => "PORTO SECO PONTA NEGRA ARMAZEM SPE LTDA",
                'empresa_id' => 1,
            ),
           array(
                "id" => 8,
                "descricao" => "INTEGRAÇÃO SKYLINE DIRETORIO DE LEITURA DOS ARQUIVOS",
                "nome_unico" => "INT_SKYLINE_FILES_DIR",
                "valor" => 'C:\laragon\www\ponta-negra\files\processar',
                'empresa_id' => 1,
            ),
            array(
                "id" => 9,
                "descricao" => "INTEGRAÇÃO SKYLINE DIRETORIO PARA SALVAR A LEITURA DOS ARQUIVOS",
                "nome_unico" => "INT_SKYLINE_FILES_DIR_TO_SAVE",
                "valor" => 'C:\laragon\www\ponta-negra\files\processados',
                'empresa_id' => 1,

            ),
            array(
                "id" => 10,
                "descricao" => "Codígo da Ponta Negra",
                "nome_unico" => "INT_PTN_NEGRA",
                "valor" => '012',
                'empresa_id' => 1,
            ),
            array(
                "id" => 11,
                "descricao" => "Determina o Endereço (ID) padrão para armazenar o estoque no momento da Operação de Descarga.",
                "nome_unico" => "ENDERECO_PADRAO_DESCARGA",
                "valor" => "19",
                "empresa_id" => 1,
            ),
            array(
                "id" => 0,
                "descricao" => "id de tipo documento para importacoes de XML de NF",
                "nome_unico" => "ID_TIPO_DOC_IMPORT_XML_NF",
                "valor" => "6",
                "empresa_id" => 1,
            ),
            array(
                "id" => 0,
                "descricao" => "DESCARGA: LISTA ENTRADAS FÍSICAS CONFORME ITENS DA DOC. ENTRADA Valores possíveis: 1 ou 0",
                "nome_unico" => "LISTA_ENTRADAS_FISICAS_CONFORME_DOC_ENTRADA",
                "valor" => "0",
                "empresa_id" => 1,
            ),
            array(
                "id" => 0,
                "descricao" => "DESCARGA: EXIBE CAMPO DE PRODUTOS Detalhamento: é utilizado no momento da descarga, geralmente em WMS Geral.",
                "nome_unico" => "DESCARGA_EXIBE_CAMPO_PRODUTO",
                "valor" => "0",
                "empresa_id" => 1,
            ),
            array(
                "id" => 0,
                "descricao" => "DESCARGA: PARAMETRO DEFINE SE INCREMENTA DOCUMENTO_MERCADORIA_ITEM CONFORME ENTRADAS FISICAS, geralmente em WMS Geral o valor e 0.",
                "nome_unico" => "DESCARGA_INCREMENTA_DOC_MERC_ITEM",
                "valor" => "0",
                "empresa_id" => 1,
            ),
            array(
                "descricao" => "Parâmetro que informa a área de picking que o sistema deverá buscar primeiramente no momento da operação de picking. O parâmetro deve ter o ID da área correspondente.",
                "nome_unico" => "PICKING_AREA_PRIMARIA",
                "valor" => "5",
                "empresa_id" => 1,
            ),
            array(
                "descricao" => "Parâmetro que diz qual é a ordenação que o cliente deseja procurar no momento da heurística que busca pelos melhores endereços onde se localizam aquele produto no momento de entregar os dados para a tela de Operação de Picking.\r\n\r\nLegenda:\r\n\r\n'controle_validade' - Validade\r\n'controle_lote' - Lote\r\n'controle_serie' - Serie\r\n'controle_fifo' - FIFO\r\nOrdenação de busca padrão: controle_validade,controle_lote,controle_serie,controle_fifo",
                "nome_unico" => "PICKING_ORDEM_HEURISTICA_BUSCA",
                "valor" => "controle_validade,controle_lote,controle_serie,controle_fifo",
                "empresa_id" => 1,
            ),
            array(
                "descricao" => "Esse parâmetro define quais áreas poderão ser utilizadas para busca de produtos em estoque na Operação de Separação (picking). Caso houver um parâmetro que já define que a \"área de picking\" deve ser utilizada como área primaria de busca de produtos, você não deverá utilizar o mesmo ID dessa área nesse parâmetro de busca secundária.\r\n\r\nPadrão a ser utilizado (não importa a ordem): 1,2,3",
                "nome_unico" => "PICKING_AREAS_SECUNDARIAS",
                "valor" => "1,2,3",
                "empresa_id" => 1,
            ),
        );

        $table = $this->table('parametro_gerais');
        $table->insert($data)->save();
    }
}
