<?php

use Core\Controller;

class UsersController extends Controller
{
    /**
    * ユーザ登録画面を返す
    * ログインしていなければログインページへ遷移する
    * 管理者権限でなければエラーページを表示する
    */
    public function add()
    {
        // ユーザ確認処理
        $this->isLogin();
        if (!$this->isSuperuser()) {
            return $this->render(array(), 'errors', 'errors');
        }
        // 新規ユーザオブジェクトを作成
        $user = Model::factory('Users')->create();
        // 権限テーブル情報取得
        $roles = Model::factory('Roles')->find_many();
        // View/users/add.phpを返す
        return $this->render(array('roles' => $roles, 'user' => $user, 'alert' => false));
    }

    /**
    * ユーザ登録処理を行う
    * ユーザの登録が成功すると管理者のマイページへ遷移する
    */
    public function create()
    {
        // ユーザ確認処理
        $this->isLogin();
        if (!$this->isSuperuser()) {
            return $this->render(array(), 'errors', 'errors');
        }
        // 新規ユーザオブジェクトの準備
        $userParams = $this->request->getParams('user');
        $newUser = Model::factory('Users')->create();
        $newUser->setParams($userParams);
        // 保存処理
        if ($newUser->save()) {
            // 成功時
            return $this->redirect('/users/show/' . $this->session->get('user_id'));
        } else {
            // 失敗時
            $roles = Model::factory('Roles')->find_many();
            $selectedRole = Model::factory('Roles')->find_one($userParams['roles_id']);
            array_unshift($roles, $selectedRole);

            return $this->render(array('user' => $newUser, 'roles' => $roles, 'alert' => true), null, 'add');
        }
    }

    /**
    * マイページを表示する
    * ログインしていない場合にはログインページへ遷移する
    * ログインしている以外のユーザのidが渡された時はエラーページを表示する
    */
    public function show($params)
    {
        $this->isLogin();
        if (!$this->isAuthId($params['id'])) {
            return $this->render(array(), 'errors', 'errors');
        }
        $user = Model::factory('Users')->find_one($params['id']);
        $users = Model::factory('Users')->find_many();
        return $this->render(array('user' => $user, 'users' => $users));
    }

    /**
    * ログインしているかチェックする
    * ログインしていなければログインページへ遷移する
    */
    private function isLogin()
    {
        if (!$this->session->isAuthenticated()) {
            $url = '/login';
            return $this->redirect($url);
        }
    }

    /**
    * ログインしているユーザのIDと渡されたIDが等しいか比べる
    */
    private function isAuthId($userId)
    {
        if ($this->session->get('user_id') == $userId) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * ログインしているユーザが管理者権限か確認する
    */
    private function isSuperuser() {
        if ($this->session->get('role') === 'superuser') {
            return true;
        } else {
            return false;
        }
    }
}
