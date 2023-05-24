<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class PadletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $padlet = new \App\Models\Padlet;
        $padlet->name = "Herr der Ringe";
        $padlet->published = new DateTime();
        $padlet->ispublic = true;
        $padlet->save();

// add entries to padlet
        $entry1 = new \App\Models\Entry;
        $entry1->textEntry = "eintrag1";

        $entry2 = new \App\Models\Entry;
        $entry2->textEntry = "eintrag2";


        $padlet->entries()->saveMany([$entry1, $entry2]);
        $padlet->save();


        $rating1 = new \App\Models\Rating;
        $rating1->rating = 1;
        $rating1->comment = "super";
        $rating1->username = "unicorn123";

        $rating2 = new \App\Models\Rating;
        $rating2->rating = 4;
        $rating2->comment = "nicht super";
        $rating2->username = "sphmr";


        $entry1->ratings()->saveMany([$rating1, $rating2]);
        $entry1->save();

        //
        $users = \App\Models\User::all()->pluck("id");
        $padlet->users()->sync($users);
        $padlet->save();
    }
}
