<?php


use Phinx\Seed\AbstractSeed;

class RolesSeeder extends AbstractSeed
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
        $data = [
            [
                'role_name' => 'superuser',
            ],
            [
                'role_name' => 'teacher',
            ],
            [
                'role_name' => 'general',
            ],
            [
                'role_name' => 'soiweb_member',
            ]
        ];

        $roles = $this->table('roles');
        $roles->insert($data)->save();
    }
}
