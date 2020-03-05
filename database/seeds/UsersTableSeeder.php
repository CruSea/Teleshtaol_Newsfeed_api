<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\NewsPostLike;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* User::truncate();
        NewsPostLike::truncate();
        DB::table('role_user')->truncate(); */

        $adminRole=Role::where('name','admin')->first();
         /* $newsmanagerRole=Role::where('name','news-manager')->first();
        $authorRole=Role::where('name','author')->first();
        $viewerRole=Role::where('name','viewer')->first(); */

        $admin=User::create ([
            'name'=>'Admin User',
            'email'=>'admin@admin.com',
            'user_type_id'=>'1',
            'password'=>Hash::make('password')
        ]);

        /*$newsmanager=User::create ([
            'name'=>'News Manager User',
            'email'=>'newsm@newsm.com',
            'user_type_id'=>'1',
            'password'=>Hash::make('password')
        ]);

        $author=User::create ([
            'name'=>'Author User',
            'email'=>'author@author.com',
            'user_type_id'=>'1',
            'password'=>Hash::make('password')
        ]);
        $viewer=User::create ([
            'name'=>'Viewer User',
            'email'=>'viewer@viewer.com',
            'user_type_id'=>'1',
            'password'=>Hash::make('password')
        ]);
        $mobile=User::create ([
            'name'=>'Mobile User',
            'email'=>'mobileuser@mobile.com',
            'user_type_id'=>'2',
            'password'=>Hash::make('password')
        ]); */

        $admin->roles()->attach($adminRole);
        /* $newsmanager->roles()->attach($newsmanagerRole);
        $author->roles()->attach($authorRole);
        $viewer->roles()->attach($viewerRole);
        $mobile->save(); */
    }
}
