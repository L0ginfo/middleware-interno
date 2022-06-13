<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Your_Name 2021-01-12 11:32:02
*/

class AddCollumnsIntegracaoTabelaLogs extends AbstractMigration
{
    public function change()
    {
      $this->table('integracao_tabela_logs')
        ->addColumn('tabela_destino', 'string', ['limit' => 255, 'null' => true])
        ->addColumn('coluna_destino', 'integer', ['null' => true])
        ->save();
    }
}
