<?php


use Phinx\Migration\AbstractMigration;

class CreateRolesTable extends AbstractMigration
{
    public function change()
    {
        $rolesTable = $this->table('roles');
        $rolesTable->addColumn('role_name', 'string', ['null' => false])
            ->create();
    }
}
