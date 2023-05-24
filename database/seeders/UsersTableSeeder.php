<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // hier werden Testdaten für den User hartgecoded --> dass ich sie
    // für den login benutzen kann

    public function run()
    {
        $user1 = new User();
        $user1->username = "unicron123";
        $user1->firstname = "Sophie";
        $user1->lastname = "Ömer";
        $user1->imageUrl = "https://www.shutterstock.com/image-vector/cute-happy-smiling-little-baby-260nw-454978309.jpg";
        $user1->password = bcrypt('secret');
        $user1->save();

        $user2 = new User();
        $user2->username = "padletuser123";
        $user2->firstname = "Maximilian";
        $user2->lastname = "Ömer";
        $user2->imageUrl = "https://www.shutterstock.com/image-vector/cute-happy-smiling-little-baby-260nw-454978309.jpg";
        $user2->password = bcrypt('secret');
        $user2->save();

        $user3 = new User();
        $user3->username = "bärli123";
        $user3->firstname = "Sebastian";
        $user3->lastname = "Riedl";
        $user3->imageUrl = "https://www.shutterstock.com/image-vector/cute-happy-smiling-little-baby-260nw-454978309.jpg";
        $user3->password = bcrypt('secret');
        $user3->save();

    }
}
