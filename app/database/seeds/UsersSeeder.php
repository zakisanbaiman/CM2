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

        //1
        $user = Sentry::createUser([
            'email'      => 'admin@cm.app',
            'password'   => '1234',
            'first_name' => 'Administrator',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($administratorsGroup);

        //2
        $user = Sentry::createUser([
            'email'      => 'vader@deathstar.com',
            'password'   => '1234',
            'first_name' => 'Darth',
            'last_name'  => 'Vader',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //3
        $user = Sentry::createUser([
            'email'      => 'lukesw@jedi.com',
            'password'   => '1234',
            'first_name' => 'Luke',
            'last_name'  => 'Skywalker',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //4
        $user = Sentry::createUser([
            'email'      => 'han@falcon.com',
            'password'   => '1234',
            'first_name' => 'Han',
            'last_name'  => 'Solo',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //5
        $user = Sentry::createUser([
            'email'      => 'leia@rebels.com',
            'password'   => '1234',
            'first_name' => 'Leia',
            'last_name'  => 'Organa',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //6
        $user = Sentry::createUser([
            'email'      => 'C-3PO@rebels.com',
            'password'   => '1234',
            'first_name' => 'C-3PO',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //7
        $user = Sentry::createUser([
            'email'      => 'R2-D2@rebels.com',
            'password'   => '1234',
            'first_name' => 'R2-D2',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //8
        $user = Sentry::createUser([
            'email'      => 'yoda@jedi.com',
            'password'   => '1234',
            'first_name' => 'Yoda',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //9
        $user = Sentry::createUser([
            'email'      => 'Obi-Wan@jedi.com',
            'password'   => '1234',
            'first_name' => 'Obi-Wan',
            'last_name'  => 'Kenobi',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //10
        $user = Sentry::createUser([
            'email'      => 'chewie@wookiee.com',
            'password'   => '1234',
            'first_name' => 'Chewbacca',
            'last_name'  => '',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);

        //11
        $user = Sentry::createUser([
            'email'      => 'jabba@tatooine.com',
            'password'   => '1234',
            'first_name' => 'Jabba',
            'last_name'  => 'Hutt',
            'activated'  => true,
        ]);
        $user->addGroup($usersGroup);
        
        //12
        $user = Sentry::createUser([
                'email'      => 'saboten@gmail.com',
                'password'   => '1234',
                'activated'  => true,
                'user_image'  => 'saboten.jpg',
                'nickname'  => 'サボテン',
        ]);
        $user->addGroup($usersGroup);
        
        //13
        $user = Sentry::createUser([
                'email'      => 'arupaka@gmail.com',
                'password'   => '1234',
                'activated'  => true,
                'user_image'  => 'arupaka.jpg',
                'nickname'  => 'アルパカ',
        ]);
        $user->addGroup($usersGroup);

        //14
        $user = Sentry::createUser([
                'email'      => 'rolex@gmail.com',
                'password'   => '1234',
                'activated'  => true,
                'user_image'  => 'rolex.jpg',
                'nickname'  => 'ロレックス',
        ]);
        $user->addGroup($usersGroup);
    }
}