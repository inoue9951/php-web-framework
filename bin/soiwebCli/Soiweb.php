<?php
require 'FileGenerator.php';
require 'Parser.php';
require 'PhinxWrapper.php';
require 'PHPUnitWrapper.php';

class Soiweb
{
    private $parser;
    private $result;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    private function parse()
    {
        $this->parser->parse();
        $this->result = $this->parser->getResult();
    }

    public function run()
    {
        $this->parse();
        switch ($this->result->command_name) {
            case 'create':
                $fileGenerator = new FileGenerator($this->result);
                $fileGenerator->create();
                exit(0);

            case 'migration':
                $phinx = new PhinxWrapper($this->result);
                $phinx->migration();
                exit(0);

            case 'migrate':
                $phinx = new PhinxWrapper($this->result);
                $phinx->migrate();
                exit(0);

            case 'rollback':
                $phinx = new PhinxWrapper($this->result);
                $phinx->rollback();
                exit(0);

            case 'status':
                $phinx = new PhinxWrapper($this->result);
                $phinx->status();
                exit(0);

            case 'seed':
                $phinx = new PhinxWrapper($this->result);
                $phinx->seed();
                exit(0);

            case 'test':
                $phpunit = new PHPUnitWrapper($this->result);
                $phpunit->test();
                exit(0);

            default:
                print_r('実行したいコマンド名を入力してください');
                echo PHP_EOL;
                exit(0);
        }
    }
}
