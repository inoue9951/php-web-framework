<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $stmt = $this->query('SELECT id FROM roles WHERE role_name = "superuser"');
        $row = $stmt->fetch();

        $data = [
            'user_id'   =>  'superuser5963',
            'password'  =>  password_hash('soiweb5963', PASSWORD_DEFAULT),
            'name'      =>  'superuser',
            'roles_id'  =>  $row['id'],
        ];

        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
