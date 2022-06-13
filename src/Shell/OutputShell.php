<?php

namespace App\Shell;

use Cake\Console\Shell;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutputShell extends Shell implements OutputInterface
{
    public function writeln($messages, $type = self::OUTPUT_NORMAL) {
        
        parent::setIo((new \Cake\Console\ConsoleIo));
        parent::out($messages);

    }

    public function write($messages, $newline = false, $options = 0) {
        
        parent::setIo((new \Cake\Console\ConsoleIo));
        parent::out($messages);

    }

    public function setVerbosity($type = self::VERBOSITY_DEBUG) {}
    public function getVerbosity() {}
    public function isQuiet() {}
    public function isVerbose() {}
    public function isVeryVerbose() {}
    public function isDebug() {}
    public function setDecorated($decorated) {}
    public function isDecorated() {}
    public function setFormatter(OutputFormatterInterface $formatter) {}
    public function getFormatter() {}
}
