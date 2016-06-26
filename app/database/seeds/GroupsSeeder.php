<?php

class GroupsSeeder extends Seeder
{
    public function run()
    {
        DB::table('groups')->truncate();

        $group = Sentry::createGroup([
            'name'        => 'Administrators',
            'permissions' =>
                [
                    'admin' => 1,
                    'user'  => 1,
                ]
        ]);

        $group = Sentry::createGroup([
            'name'        => 'Users',
            'permissions' =>
                [
                    'admin'  => 0,
                    'user'   => 1,
                ]
        ]);

    }
}
