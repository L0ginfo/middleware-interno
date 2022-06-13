<?php
/**
* Created: Silvio Regis 16:45 19/06/2020
* Author: Allan Baron 15:56 24/06/2020 
*/

use Phinx\Migration\AbstractMigration;

class IntegracaoTabelaLog extends AbstractMigration
{
    public function up()
    {
      if(!$this->hasTable('integracao_tabela_logs')){
        $this->table('integracao_tabela_logs')
          ->addColumn('integracao_id', 'integer')
          ->addColumn('tabela', 'string', ['limit' => 255])
          ->addColumn('coluna', 'integer', ['null' => true])
          ->addColumn('operacao','string', ['limit' => 255])
          ->addColumn('data', 'text', ['null' => true])
          ->addColumn('error', 'text', ['null' => true])
          ->addColumn('status', 'integer')
          ->addColumn('create_at', 'datetime')
          ->addForeignKey('integracao_id', 'integracoes', 'id')
          ->save();
      }
    }

    public function down() {
          
    }
}
