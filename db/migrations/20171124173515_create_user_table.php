<?php


use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    public function change()
    {
        $userTable = $this->table('users', ['id' => false, 'primary_key' => ['user_id']]);
        $userTable->addColumn('user_id', 'string', ['null' => false])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('roles_id', 'integer', ['null' => false])
            ->addTimestamps()
            ->addForeignKey('roles_id', 'roles', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
