<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // User::factory(5)->create()->each(function($user) {
        //     $user->transaction()->saveMany(Transaction::factory(1)->create(['user_id' => $user->id, 'book_id' => rand(1,5)])->each(function($transaction) {
        //         $transaction->borrowing()->save(Borrowing::factory()->create(['transaction_id' => $transaction->id, 'user_id' => rand(1,5)]));
        //     }));
        // });

        User::factory(5)->create();
    }
}
