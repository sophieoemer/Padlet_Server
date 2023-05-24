<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class EntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* $entry = new \App\Models\Entry;
        $entry->textEntry = "Entry text hihi";
        $entry->save();
// add ratings to entry
        $rating1 = new \App\Models\Entry;
        $rating1->rating = 1;
        $rating1->comment = "super";
        $rating1->username = "unicorn123";

        $rating2 = new \App\Models\Entry;
        $rating2->rating = 4;
        $rating2->comment = "nicht super";
        $rating2->username = "sphmr";


        $entry->ratings()->saveMany([$rating1, $rating2]);
        $entry->save();
       */
    }
}
