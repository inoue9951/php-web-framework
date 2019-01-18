<?php
namespace Config;

class Routes
{
    protected $routes = array(
        // root
        '/' =>  array('controller' => 'account', 'action' => 'index', 'method' => 'get'),

        // user関連のルーティング
        'users' => array('controller' => 'users', 'action' => 'index', 'method' => 'get'),
        'users/add' => array('controller' => 'users', 'action' => 'add', 'method' => 'get'),
        'users/create' => array('controller' => 'users', 'action' => 'create', 'method' => 'post'),
        'users/show/:id' => array('controller' => 'users', 'action' => 'show', 'method' => 'get'),
        // 'users/edit/:id' => array('controller' => 'users', 'action' => 'edit', 'method' => 'get'),
        // 'users/update/:id' => array('controller' => 'users', 'action' => 'update', 'method' => 'put'),
        // 'users/delete/:id' => array('controller' => 'users', 'action' => 'delete', 'method' => 'delete'),

        // login, logout
        'login' => array('controller' => 'account', 'action' => 'index', 'method' => 'get'),
        'login/auth' => array('controller' => 'account', 'action' => 'login', 'method' => 'post'),
        'logout' => array('controller' => 'account', 'action' => 'logout', 'method' => 'get'),
    );

    public function getRoutes()
    {
        return $this->routes;
    }
}
