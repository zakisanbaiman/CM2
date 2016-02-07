<?php

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users_groups')->truncate();
        DB::table('throttle')->truncate();
        DB::table('users')->truncate();

        $administratorsGroup = Sentry::getGroupProvider()->findById(1);
        $usersGroup          = Sentry::getGroupProvider()->findById(2);

        $user = Sentry::createUser([
            'email'      => 'admin@cm.app',
            'password'   => '1234',
            'first_name' => 'Administrator',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($administratorsGroup);

        $user = Sentry::createUser([
            'email'      => 'lukesw@rebels.com',
            'password'   => '1234',
            'first_name' => 'Luke',
            'last_name'  => 'Skywalker',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

    }
}