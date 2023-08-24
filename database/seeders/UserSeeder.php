<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
/*         DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@agoralabs.org',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]); */

        DB::table('users')->insert([
            'name' => 'Cathy',
            'lastname' => 'Coulaly',
            'email' => 'cathy.coulaly@agoralabs.org',
            'avatar' => '/team-member-1.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Joseph',
            'lastname' => 'Future',
            'email' => 'joseph.future@agoralabs.org',
            'avatar' => '/team-member-2.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Dorine',
            'lastname' => 'Michou',
            'email' => 'dorine.michou@agoralabs.org',
            'avatar' => '/team-member-3.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Wesley',
            'lastname' => 'Weezy',
            'email' => 'wesley.weezy@agoralabs.org',
            'avatar' => '/team-member-4.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Marie',
            'lastname' => 'Jose',
            'email' => 'marie.jo@agoralabs.org',
            'avatar' => '/team-member-5.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Charles',
            'lastname' => 'Champ',
            'email' => 'charles.champ@agoralabs.org',
            'avatar' => '/team-member-6.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Boris',
            'lastname' => 'John',
            'email' => 'boris.john@agoralabs.org',
            'avatar' => '/team-member-7.jpg',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //Tasks
        DB::table('tasks')->insert([
            'user_id' => 1,
            'name' => 'IMDB',
            'priority' => 2,
            'status' => 'overdue',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
            'scheduled_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'user_id' => 2,
            'name' => 'Frontend',
            'priority' => 2,
            'status' => 'ongoing',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
            'scheduled_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'user_id' => 3,
            'name' => 'Backend',
            'priority' => 2,
            'status' => 'completed',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
            'scheduled_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'user_id' => 4,
            'name' => 'Database',
            'priority' => 2,
            'status' => 'ongoing',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit',
            'scheduled_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
