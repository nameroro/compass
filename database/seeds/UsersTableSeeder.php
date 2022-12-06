<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::table('users') -> insert([
            [
                'over_name' => '大沢',
                'under_name' => '亮輔',
                'over_name_kana' => 'オオサワ',
                'under_name_kana' => 'リョウスケ',
                'mail_address' => 'mail@mail',
                'sex' => '1',
                'birth_day' => '1997-02-25',
                'role' => '4',
                'password' =>  bcrypt('password'),
            ],
        ]);
    }
}
