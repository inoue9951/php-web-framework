<?php
namespace Config;

class Connection {

    protected $setting;

    public function __construct()
    {
        $filename = dirname(__FILE__, 2) . '/config/configurations.php';
        $this->setting = require($filename);
    }

    public function connect()
    {
        //DB接続
        $params = $this->setting['environments'];
        if (getenv('exec_environment')) {
            $key = getenv('exec_environment');
        } else {
            $key = $params['default_database'];
        }
        \ORM::configure('mysql:host=' . $params[$key]['host'] . ';dbname=' . $params[$key]['name']);
        \ORM::configure('username', $params[$key]['user']);
        \ORM::configure('password', $params[$key]['pass']);
    }
}
