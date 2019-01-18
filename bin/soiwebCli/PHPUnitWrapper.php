<?php

class PHPUnitWrapper
{
    private $cmdPath;
    private $configPath;
    private $cliArgs;

    public function __construct($cliArgs)
    {
        $this->cmdPath = dirname(__FILE__, 3) . '/vendor/bin/phpunit';
        $this->configPath = dirname(__FILE__, 3) . '/config/phpunit.xml';
        $this->cliArgs = $cliArgs;
    }

    public function test()
    {
        $cmd = $this->cliArgs->command->args['test_path'];
        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    private function setConfig($cmd)
    {
        $cmd .= ' -c ' . $this->configPath . ' --colors=always';
        return $cmd;
    }

    private function cmdExec($cmd)
    {
        echo $this->cliArgs->command_name . ' running' . PHP_EOL;
        exec($this->cmdPath . ' ' . $cmd, $output);
        $this->printResult($output);
    }

    private function printResult($output) {
        foreach ($output as $result) {
            echo $result . PHP_EOL;
        }
    }

}
