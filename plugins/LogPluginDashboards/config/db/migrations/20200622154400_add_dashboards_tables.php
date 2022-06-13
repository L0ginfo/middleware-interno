<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-22 15:44:00
*/

class AddDashboardsTables extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboards')
            ->addColumn('titulo', 'string')
            ->addColumn('perfil_id', 'integer', ['null' => true])
            ->addColumn('usuario_id', 'integer', ['null' => true])
            ->addColumn('ordem', 'integer', ['null' => true])
            ->addForeignKey('perfil_id', 'perfis', 'id')
            ->addForeignKey('usuario_id', 'usuarios', 'id')
            ->create();

        $this->table('dashboard_cards')
            ->addColumn('titulo', 'string')
            ->addColumn('ordem', 'integer', ['null' => true])
            ->addColumn('cor', 'string')
            ->addColumn('url', 'string', ['null' => true])
            ->addColumn('controller', 'string', ['null' => true])
            ->addColumn('action', 'string', ['null' => true])
            ->addColumn('icone', 'string', ['null' => true])
            ->addColumn('consulta_coluna_dado', 'string', ['null' => true])
            ->addColumn('dashboard_id', 'integer')
            ->addForeignKey('dashboard_id', 'dashboards', 'id')
            ->create();

        $this->table('dashboard_grafico_formatos')
            ->addColumn('descricao', 'string')
            ->create();

        $this->table('dashboard_grafico_tipos')
            ->addColumn('descricao', 'string')
            ->addColumn('grafico_params', 'string', ['null' => true])
            ->addColumn('dashboard_grafico_formato_id', 'integer')
            ->addForeignKey('dashboard_grafico_formato_id', 'dashboard_grafico_formatos', 'id')
            ->create();
        
        $this->table('dashboard_graficos')
            ->addColumn('ordem', 'integer', ['null' => true])
            ->addColumn('responsive_options', 'string', ['null' => true])
            ->addColumn('consulta_id', 'integer', ['null' => true])
            ->addColumn('dashboard_id', 'integer')
            ->addColumn('dashboard_grafico_tipo_id', 'integer')
            ->addForeignKey('consulta_id', 'consultas', 'id')
            ->addForeignKey('dashboard_id', 'dashboards', 'id')
            ->addForeignKey('dashboard_grafico_tipo_id', 'dashboard_grafico_tipos', 'id')
            ->create();

    }
}
