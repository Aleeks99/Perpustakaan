<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\User;
use App\Models\Admin;
use App\Models\Member;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Database\Seeders\BookSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\WaitingSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\BorrowingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create(
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ClassroomSeeder::class,
            StudentSeeder::class,
            BookSeeder::class,
            ItemsSeeder::class,
            BorrowingSeeder::class,
            ReturningSeeder::class,
            WaitingSeeder::class,
            SettingSeeder::class
        ]);

        //assign role to all
        Role::findByName('admin')->users()->sync(User::whereBetween('id', ['1', '2'])->pluck('id'));
        Role::findByName('librarian')->users()->sync(User::whereBetween('id', ['3', '5'])->pluck('id'));
        // Role::findByName('member')->users()->sync(User::whereBetween('id', ['6', '10'])->pluck('id'));
        // Transaction::factory(5)->has(Borrowing::factory(1))->create();
    }
}
