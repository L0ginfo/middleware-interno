<?php
// src/Shell/LoginfoPluginManagerShell.php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Plugin;

use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use App\Shell\OutputShell;
use App\Util\DirectoryFileUtil;
use Cake\Utility\Inflector;

class LoginfoPluginManagerShell extends Shell
{
    public function __construct() 
    {
        parent::__construct();
        $this->output = new OutputShell();
    }

    public function phinx($sAction, ...$aMoreActions)
    {
        $sPluginNameArg = @$aMoreActions[0];
        
        $sMigrationNameArg = @$aMoreActions[1];

        if (!$sAction)
            return;

        $aPlugins = Plugin::loaded();

        foreach ($aPlugins as $sPlugin) {
            
            //Se não for um plugin da Loginfo
            if (strpos($sPlugin, 'LogPlugin') === false)
                continue;
                
            if ($sPluginNameArg && $sPluginNameArg != $sPlugin)
                continue;

            $this->output->writeln('');
            $this->output->writeln('========== Loginfo Plugin: ' . $sPlugin . ' Start ==========');
            $this->output->writeln('');

            $oManager = $this->getPhinxManager($sPlugin);

            if (!$oManager) {
                $this->output->writeln('========== Loginfo Plugin Manager ==========');
                $this->output->writeln('O plugin ' . $sPlugin . ' não tem um phinx.php configurado!');
                $this->output->writeln('========== Loginfo Plugin Manager ==========');
                continue;
            }
            
            if ($sAction == 'migrate')
                $oManager->migrate('development');
            elseif ($sAction == 'rollback')
                $oManager->rollback('development');
            elseif ($sAction == 'create')
                $this->phinxCreateMigration($sMigrationNameArg, $sPlugin);

            
            $this->output->writeln('');
            $this->output->writeln('========== Loginfo Plugin: ' . $sPlugin . ' End ==========');
            $this->output->writeln('');
        }
    }

    private function phinxCreateMigration($sMigrationNameArg, $sPluginName)
    {
        $sMigrationName = Inflector::underscore($sMigrationNameArg);
        $sSamplePluginMigrationName = 'loginfo_plugin_migration.sample';

        if (!$sMigrationName) {
            $this->output->writeln('Ops, parece que você não informou o nome da Migration!');
            return;
        }

        $sPluginMigrationPhpContent = file_get_contents(ROOT . DS . 'config' . DS . 'samples' . DS . $sSamplePluginMigrationName);
        $sPluginMigrationPhpContent = str_replace('[MIGRATION_NAME]', $sMigrationNameArg, $sPluginMigrationPhpContent);
        $sPluginMigrationPhpContent = str_replace('[DATE_CREATION]', date('Y-m-d H:i:s'), $sPluginMigrationPhpContent);

        $sPluginDir = ROOT . DS . 'plugins' . DS . $sPluginName . DS;
        $sMigrationNameWithTime = date('YmdHis') . '_' . $sMigrationName . '.php';
        $sMigrationDir = $sPluginDir . 'config' . DS . 'db' . DS . 'migrations' . DS . $sMigrationNameWithTime;

        DirectoryFileUtil::fileForceContents($sMigrationDir, $sPluginMigrationPhpContent);

        if (!file_exists($sMigrationDir)) 
            $this->output->writeln('Não foi possível criar o arquivo no diretório: ' . $sMigrationDir);
            
        $this->output->writeln(" == Migration criada: \r\n" . $sMigrationDir);
    }

    private function getPhinxManager($sPluginName)
    {
        $sConfigFile = ROOT . DS . 'plugins' . DS . $sPluginName . DS . 'phinx.php';
        
        if (!file_exists($sConfigFile))
            return null;

        $configArray = require($sConfigFile);
        $config = new Config($configArray);

        return new Manager($config, new StringInput(' '), $this->output);
    }

    

}