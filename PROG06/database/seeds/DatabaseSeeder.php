<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $user1 = User::create([
            'name'          => 'Teacher1',
            'email'         => 'teacher1@gmail.com',
            'password'      => bcrypt('admin123'),
            'phone'         => '0123456789',
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user1->assignRole('Teacher');

        $user2 = User::create([
            'name'          => 'Teacher2',
            'email'         => 'teacher2@gmail.com',
            'password'      => bcrypt('admin123'),
            'phone'         => '0123456789',
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user2->assignRole('Teacher');

        $user3 = User::create([
            'name'          => 'Student1',
            'email'         => 'student1@gmail.com',
            'password'      => bcrypt('admin123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user3->assignRole('Student');

        DB::table('teachers')->insert([
            [
                'user_id'           => $user1->id,
                'gender'            => 'female',
                'phone'             => '0123456789',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        DB::table('teachers')->insert([
            [
                'user_id'           => $user2->id,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        DB::table('students')->insert([
            [
                'user_id'           => $user3->id,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);

        $user4 = User::create([
            'name'          => 'Student2',
            'email'         => 'student2@gmail.com',
            'password'      => bcrypt('admin123'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $user4->assignRole('Student');
        // Add this missing students record for user4
        DB::table('students')->insert([
            [
                'user_id'           => $user4->id,
                'gender'            => 'female',
                'phone'             => '0123456789',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
