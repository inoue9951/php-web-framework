<?php

class PhinxWrapper
{
    private $cmdPath;
    private $configPath;
    private $cliArgs;

    public function __construct($cliArgs)
    {
        $this->cmdPath = dirname(__FILE__, 3) . '/vendor/bin/phinx';
        $this->configPath = dirname(__FILE__, 3) . '/config/configurations.php';
        $this->cliArgs = $cliArgs;
    }

    public function migration()
    {
        $cmd = 'create ' . $this->cliArgs->command->args['file_name'];
        $options = '';
        foreach ($this->cliArgs->command->options as $key => $value) {
            if (empty($value)) continue;
            $options .= ' --' . $key . '=' .$value;
        }
        $cmd .= $options;

        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    public function migrate()
    {
        $cmd = 'migrate';
        $optionArray = $this->cliArgs->command->options;
        $env = is_null($optionArray['environment']) ? '' : ' -e ' . $optionArray['environment'];
        $target = is_null($optionArray['target']) ? '' : ' -t ' . $optionArray['target'];
        $cmd = $cmd . $env . $target;

        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    public function rollback()
    {
        $cmd = 'rollback';
        $optionArray = $this->cliArgs->command->options;
        $env = is_null($optionArray['environment']) ? '' : ' -e ' . $optionArray['environment'];
        $target = is_null($optionArray['target']) ? '' : ' -t ' . $optionArray['target'];
        $date = is_null($optionArray['date']) ? '' : ' -d ' . $optionArray['date'];
        $cmd = $cmd . $env . $target . $date;

        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    public function status()
    {
        $cmd = 'status';
        $optionArray = $this->cliArgs->command->options;
        $env = is_null($optionArray['environment']) ? '' : ' -e ' . $optionArray['environment'];
        $cmd = $cmd . $env;

        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    public function seed()
    {
        $cmd = 'seed:' . $this->cliArgs->command->args['operation'];
        $optionArray = $this->cliArgs->command->options;
        if ($this->cliArgs->command->args['operation'] == 'create') {
            $file = is_null($this->cliArgs->command->args['file_name']) ? '' : ' ' . $this->cliArgs->command->args['file_name'];
            $cmd .= $file;
        } else if ($this->cliArgs->command->args['operation'] == 'run') {
            $file = is_null($optionArray['seed']) ? '' : ' -s ' . $optionArray['seed'];
            $cmd .= $file;
        }
        $env = is_null($optionArray['environment']) ? '' : ' -e ' . $optionArray['environment'];
        $cmd = $cmd . $env;

        $cmd = $this->setConfig($cmd);
        $this->cmdExec($cmd);
    }

    private function setConfig($cmd)
    {
        $cmd .= ' -c ' . $this->configPath;
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
