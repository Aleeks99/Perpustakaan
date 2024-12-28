<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Items;
use App\Models\Returning;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReturningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 2 ; $i++) { 
            Returning::factory()->create(['transaction_id' => $i+1, 'user_id' => rand(3,5)]);
            
        }

        Items::join('transactions', 'items.id', '=', 'transactions.item_id')
             ->whereBetween('transactions.id', [1, 2])
             ->update([
                'status' => 'available'
             ]);

        Transaction::whereBetween('transactions.id', [1, 2])->update(['detail' => 'return']);
    }
}
