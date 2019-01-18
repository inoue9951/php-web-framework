<?php

require dirname(__FILE__, 3) . '/vendor/autoload.php';

class Parser
{
    public $parser;
    protected $result = null;

    public function __construct()
    {
        $this->parser = new Console_CommandLine(array(
            'description'   =>  'Soiwebコマンドラインツール',
        ));
        $this->setting();
    }

    private function setting()
    {
        // createサブコマンドの設定
        $createCmd = $this->parser->addCommand('create', array(
            'description'   =>  'Create Controller or Model File',
            'aliases'       =>  array('c'),
        ));
        $createCmd->addArgument('file_type', array(
            'description'   =>  'input controller or model',
        ));
        $createCmd->addArgument('file_name', array(
            'description'   =>  'input file names',
            'multiple'      => true,
        ));

        // migrationサブコマンドの設定
        $migrationCmd = $this->parser->addCommand('migration', array(
            'description'   =>  'マイグレーションファイルを作成します.'. PHP_EOL .
                                'phinxのcreateコマンドをラップしています.' . PHP_EOL .
                                'templateオプションとclassオプションを同時に使用することはできません',
        ));
        $migrationCmd->addArgument('file_name', array(
            'description'   =>  'input file name',
        ));
        $migrationCmd->addOption('template', array(
            'long_name'     =>  '--template',
            'description'   =>  'You are able to override the template.',
            'action'        =>  'StoreString',
            'help_name'     =>  'template_file_name'
        ));
        $migrationCmd->addOption('class', array(
            'long_name'     =>  '--class',
            'description'   =>  'You can supply a template generating class.',
            'action'        =>  'StoreString',
            'help_name'     =>  'class_name'
        ));

        // migrateサブコマンドの設定
        $migrateCmd = $this->parser->addCommand('migrate', array(
            'description'   =>  'マイグレーションを行います.' . PHP_EOL .
                                'phinxのmigrateコマンドをラップしています.',
        ));
        $migrateCmd->addOption('environment', array(
            'short_name'    =>  '-e',
            'description'   =>  'setting environment.',
            'action'        =>  'StoreString',
            'help_name'     =>  'environment',
        ));
        $migrateCmd->addOption('target', array(
            'short_name'    =>  '-t',
            'long_name'     =>  '--target',
            'description'   =>  'To migrate to a specific version.',
            'action'        =>  'StoreString',
        ));

        // rollbackサブコマンドの設定
        $rollbackCmd = $this->parser->addCommand('rollback', array(
            'description'   =>  'ロールバックを行います' . PHP_EOL .
                                'phinxのrollbackコマンドをラップしています.',
        ));
        $rollbackCmd->addOption('environment', array(
            'short_name'    =>  '-e',
            'description'   =>  'setting environment.',
            'action'        =>  'StoreString',
            'help_name'     =>  'environment',
        ));
        $rollbackCmd->addOption('target', array(
            'short_name'    =>  '-t',
            'long_name'     =>  '--target',
            'description'   =>  'To migrate to a specific version.',
            'action'        =>  'StoreString',
        ));
        $rollbackCmd->addOption('date', array(
            'short_name'    =>  '-d',
            'long_name'     =>  '--date',
            'description'   =>  'To rollback all migrations to a specific date.',
            'action'        =>  'StoreString',
        ));

        // statusサブコマンドの設定
        $statusCmd = $this->parser->addCommand('status', array(
            'description'   =>  'マイグレーションのステータスを確認します.' . PHP_EOL .
                                'phinxのstatusコマンドをラップしています.',
        ));
        $statusCmd->addOption('environment', array(
            'short_name'    =>  '-e',
            'description'   =>  'setting environment.',
            'action'        =>  'StoreString',
            'help_name'     =>  'environment',
        ));

        // seedサブコマンドの設定
        $seedCmd = $this->parser->addCommand('seed', array(
            'description'   =>  'seedを作成したりDBへの挿入を行います.' . PHP_EOL .
                                'phinxのseedコマンドをラップしています.',
        ));
        $seedCmd->addArgument('operation', array(
            'description'   =>  'create or run'
        ));
        $seedCmd->addArgument('file_name', array(
            'description'   =>  'The name of to create seed file',
            'optional'      =>  true,
        ));
        $seedCmd->addOption('environment', array(
            'short_name'    =>  '-e',
            'description'   =>  'setting environment.',
            'action'        =>  'StoreString',
            'help_name'     =>  'environment',
        ));
        $seedCmd->addOption('seed', array(
            'short_name'    =>  '-s',
            'long_name'     =>  '--seed',
            'description'   =>  'To run only one seed class When operation is "run"',
            'action'        =>  'StoreString',
        ));

        // testサブコマンドの設定
        $testCmd = $this->parser->addCommand('test', array(
            'description'   =>  'phpunitのテストランナーを一部ラップしています',
        ));
        $testCmd->addArgument('test_path', array(
            'description'   =>  'テストを実行するファイル',
            'optional'      =>  true,
        ));
    }

    public function parse()
    {
        try {
            $result = $this->parser->parse();
            $this->result = $result;
        } catch (Exception $exc) {
            $this->parser->displayError($exc->getMessage());
        }
    }

    public function getResult()
    {
        return $this->result;
    }
}
