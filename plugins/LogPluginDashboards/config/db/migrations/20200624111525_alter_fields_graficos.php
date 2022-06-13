<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-24 11:15:25
*/

class AlterFieldsGraficos extends AbstractMigration
{
    public function up() 
    {
        $this->table('dashboard_graficos')
            ->changeColumn('responsive_options', 'text')
            ->update();
            
        $this->table('dashboard_grafico_tipos')
            ->changeColumn('descricao', 'text')
            ->changeColumn('grafico_params', 'text')
            ->update();
    }

    public function down() 
    {
        
    }
}
