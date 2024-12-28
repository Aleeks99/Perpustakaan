<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Items;
use App\Models\Borrowing;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $item_id = range(1,5);
        $member_id = range(6,10);
        shuffle($item_id);
        shuffle($member_id);

        for ($i=0; $i < 5 ; $i++) { 
            
            Transaction::factory()->create(['user_id' => $member_id[$i], 'item_id' => $item_id[$i]]);
            Borrowing::factory()->create(['transaction_id' => $i+1, 'user_id' => rand(3,5)]);
            // Book::whereBetween('id', ['1', '5'])->update(['status' => 'borrowed']);
            Items::whereBetween('id', ['1', '5'])->update(['status' => 'borrowed']);
        }
    }
}