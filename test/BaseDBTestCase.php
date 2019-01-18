<?php
use PHPUnit\DbUnit\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Operation\Factory;
use PHPUnit\DbUnit\DataSet\ArrayDataSet;

class BaseDBTestCase extends TestCase
{
    static private $pdo = null;
    private $conn = null;
    private $dataSet;
    private $fixture;

    /**
    * PHPUnitをTest環境のDBに接続する
    */
    public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo === null) {
                $setting = require(dirname(__FILE__, 2) . '/config/configurations.php');
                $params = $setting['environments'];
                self::$pdo = new PDO(
                    'mysql:host=' . $params['test']['host'] . ';dbname=' . $params['test']['name'] . ';charset=utf8',
                    $params['test']['user'],
                    $params['test']['pass']
                );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo);
        }
        return $this->conn;
    }

    /**
    * Testのためのデータセットを取得する
    */
    public function getDataSet()
    {
        return $this->dataSet;
    }

    /**
    * Testの前準備をする
    * Fixtureを用意しておく
    * 継承先のクラスで呼び出す
    */
    protected function setUp() {
        $this->dataSet = new ArrayDataSet($this->getFixture());
        parent::setUp();
    }

    /**
    * Testの後処理をする
    * DBのクリーンアップを行う
    * 継承先のクラスで呼び出す
    */
    public function getTearDownOperation() {
        return Factory::TRUNCATE();
    }

    /**
    * Fixtureをセットする
    */
    public function setFixture($fixture)
    {
        $this->fixture = $fixture;
    }

    /**
    * Fixtureを取得する
    */
    public function getFixture()
    {
        return $this->fixture;
    }
}
