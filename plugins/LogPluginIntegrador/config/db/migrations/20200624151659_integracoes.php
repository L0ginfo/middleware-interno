<?php
/**
* Created: Silvio Regis 16:45 19/06/2020
* Author: Allan Baron 15:56 24/06/2020 
*/

use Phinx\Migration\AbstractMigration;

class Integracoes extends AbstractMigration
{
      public function up()
      {
            if(!$this->hasTable('integracoes')){
                  $this->table('integracoes')
                  ->addColumn('nome', 'string')
                  ->addColumn('descricao', 'text')
                  ->addColumn('codigo_unico', 'string')
                  ->addColumn('ativo', 'integer')
                  ->addColumn('gravar_log', 'integer', ['default' => 1])
                  ->addColumn('acesso_externo', 'integer', ['default' => 0])
                  ->addColumn('tipo', 'enum', ['values' => ['API', 'Database']])
                  ->addColumn('url_endpoint', 'string', ['null' => true])
                  ->addColumn('json_header', 'text', ['null' => true])
                  ->addColumn('private_key', 'string')
                  ->addColumn('db_host', 'string', ['null' => true])
                  ->addColumn('db_porta', 'integer', ['null' => true])
                  ->addColumn('db_database', 'string', ['null' => true])
                  ->addColumn('db_user', 'string', ['null' => true])
                  ->addColumn('db_pass', 'string', ['null' => true])
                  ->addColumn('data_integracao', 'datetime', ['null' => true])
                  ->addIndex(['codigo_unico'], ['unique' => true])
                  ->save();

            }

            if(!$this->hasTable('integracao_traducoes')){
                  $this->table('integracao_traducoes')
                  ->addColumn('integracao_id', 'integer')
                  ->addColumn('nested_json_translate', 'text')
                  ->addColumn('observacao', 'text')
                  ->addForeignKey('integracao_id', 'integracoes', 'id')
                  ->save();
            }

            if(!$this->hasTable('integracao_logs')){
                  $this->table('integracao_logs')
                  ->addColumn('integracao_id', 'integer')
                  ->addColumn('integracao_traducao_id', 'integer', ['null' => true])
                  ->addColumn('url_requisitada', 'text')
                  ->addColumn('header_enviado', 'text', ['null' => true])
                  ->addColumn('header_recebido', 'text', ['null' => true])
                  ->addColumn('json_enviado', 'text', ['null' => true])
                  ->addColumn('json_recebido', 'text', ['null' => true])
                  ->addColumn('json_traduzido', 'text', ['null' => true])
                  ->addColumn('status', 'integer')
                  ->addColumn('descricao', 'text', ['null' => true])
                  ->addColumn('stackerror', 'text', ['null' => true])
                  ->addForeignKey('integracao_id', 'integracoes', 'id')
                  ->addForeignKey('integracao_traducao_id', 'integracao_traducoes', 'id')
                  ->save();
            }
      }     

      public function down() {}
}
