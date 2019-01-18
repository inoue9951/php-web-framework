<?php

use Core\Controller;

class accountController extends Controller
{
    public function index()
    {
        if (!$this->isLogin()) {
            return $this->render(array('alert' => false));
        }
    }

    public function login()
    {
        $params = $this->request->getParams('login');
        $user = Model::factory('Users')->find_one($params['user_id']);
        if ($user) {
            if (password_verify($params['password'], $user->password)) {
                $this->session->setAuthenticated(true);
                $this->session->set('user_id', $user->user_id);
                $this->session->set('role', $user->roles()->find_one()->role_name);

                $url = '/users/show/' . $user->user_id;
                return $this->redirect($url);
            }
        }
        return $this->render(array('alert' => true), null, 'index');
    }

    public function logout()
    {
        if ($this->session->isAuthenticated()) {
            $this->session->clear();
            $this->session->setAuthenticated(false);
         }
         return $this->redirect('/login');
    }

    public function isLogin()
    {
        if ($this->session->isAuthenticated()) {
            $url = '/users/show/' . $this->session->get('user_id');
            return $this->redirect($url);
        }
        return false;
    }
}
