<?php
require dirname(__FILE__, 2) . '/BaseDBTestCase.php';

use Config\Connection;

class UsersTest extends BaseDBTestCase
{
    protected $user;

    protected function setUp()
    {
        // 接続
        $conn = new Connection();
        $conn->connect();
        // ユーザオブジェクトの作成
        $this->user = Model::Factory('Users')->create();
        // Fixtureのセット
        $this->setFixture(require(dirname(__FILE__, 2) . '/DataSet/Models/usersFixture.php'));
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function setReflection($class, $method)
    {
        $method = new ReflectionMethod($class, $method);
        $method->setAccessible(true);
        return $method;
    }

    // 以下テストメソッド

    /**
    * @group checkParamsMethod
    */
    public function testCheckParamsFalse()
    {
        $checkParams = $this->setReflection('Users', 'checkParams');
        $this->assertFalse($checkParams->invoke($this->user));
    }

    /**
    * @group checkParamsMethod
    */
    public function testCheckParamsTrue()
    {

        $checkParams = $this->setReflection('Users', 'checkParams');

        $params = array('user_id' => 'sampleId', 'password' => 'samplePassword', 'name' => 'name', 'roles_id' => '1');
        $this->user->setParams($params);

        $this->assertTrue($checkParams->invoke($this->user));
    }

    /**
    * @group checkFormatMethod
    * @dataProvider falseFormat
    */
    public function testCheckFormatFalse($param)
    {
        $checkFormat = $this->setReflection('Users', 'checkFormat');
        $this->assertFalse($checkFormat->invoke($this->user, $param));
    }

    public function falseFormat()
    {
        return [
            '半角英数字以外を含む' => ['@aaaaaaaa'],
            '8文字より短い' =>  ['aaaa'],
            '空文字'    =>  [' 　']
        ];
    }

    /**
    * @group checkFormatMethod
    */
    public function testCheckFormatTrue()
    {
        $checkFormat = $this->setReflection('Users', 'checkFormat');
        $param = 'sampleParam1234';
        $this->assertTrue($checkFormat->invoke($this->user, $param));
    }

    /**
    * @group checkNotBlankMethod
    * @dataProvider falseNotBlank
    */
    public function testCheckBlankFalse($param)
    {
        $checkNotBlank = $this->setReflection('Users', 'checkNotBlank');
        $this->assertFalse($checkNotBlank->invoke($this->user, $param));
    }

    public function falseNotBlank()
    {
        return [
            'null'  =>  [null],
            '半角空白一文字'    =>  [' '],
            '全角空白一文字'    =>  ['　'],
            '半角全角空白'  =>  [' 　'],
        ];
    }

    /**
    * @group checkNotBlankMethod
    */
    public function testCheckBlankTrue()
    {
        $checkNotBlank = $this->setReflection('Users', 'checkNotBlank');
        $param = 'sampleParam';
        $this->assertTrue($checkNotBlank->invoke($this->user, $param));
    }

    /**
    * @group checkDoubleMethod
    */
    public function testCheckDoubleFalse()
    {
        $checkDouble = $this->setReflection('Users', 'checkDouble');
        $column = 'user_id';
        $param = 'sampleUserId';
        $this->assertFalse($checkDouble->invoke($this->user, $column, $param));
    }

    /**
    * @group checkDoubleMethod
    */
    public function testCheckDoubleTrue()
    {
        $checkDouble = $this->setReflection('Users', 'checkDouble');
        $column = 'user_id';
        $param = 'sampleUserId1234';
        $this->assertTrue($checkDouble->invoke($this->user, $column, $param));
    }

    /**
    * @group saveMethod
    */
    public function testSaveTrue()
    {
        $params = array(
            'user_id'   =>  'saveTestId',
            'password'  =>  'saveTestPass',
            'name'      =>  'saveTest',
            'roles_id'  =>  1,
        );
        $this->user->setParams($params);
        $expected = count($this->getFixture()['users']) + 1;
        $this->assertTrue($this->user->save());
        $this->assertEquals($expected, $this->getConnection()->getRowCount('users'));
    }

    /**
    * @group saveMethod
    */
    public function testSaveFalse()
    {
        $params = array(
            'user_id'   =>  '@@@falseUserId',
            'password'  =>  'falseUserPass',
            'name'      =>  'falseSave',
            'roles_id'  =>  1,
        );
        $this->user->setParams($params);
        $expected = count($this->getFixture()['users']);
        $this->assertFalse($this->user->save());
        $this->assertEquals($expected, $this->getConnection()->getRowCount('users'));
    }
}
