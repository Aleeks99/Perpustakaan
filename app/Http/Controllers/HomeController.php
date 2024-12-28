<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Book;
use App\Models\Items;
use App\Models\Returning;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasRole(['admin', 'librarian'])) {
            # code...
            //header
            $data['title'] = 'Dashboard';

            //data
            // $items = Items::all();
            // $books = Book::all();
            // $category = Category::all();
            // $transaction = Transaction::all();
            $data['items'] = Items::all();
            $data['catName'] = Transaction::join('items', 'items.id', '=', 'transactions.item_id')->join('books', 'books.id', '=', 'items.book_id')->join('categories', 'categories.id', '=', 'books.category_id')->select('categories.name', DB::raw('COUNT(*) as count'))->groupBy('categories.name')->pluck('name');
            $data['catCount'] = Transaction::join('items', 'items.id', '=', 'transactions.item_id')->join('books', 'books.id', '=', 'items.book_id')->join('categories', 'categories.id', '=', 'books.category_id')->select('categories.name', DB::raw('COUNT(*) as count'))->groupBy('categories.name')->pluck('count');
            $data['books'] = Transaction::join('items', 'items.id', '=', 'transactions.item_id')->join('books', 'books.id', '=', 'items.book_id')->select('books.title', DB::raw('COUNT(*) as count'))->groupBy('books.id')->orderBy('count', 'DESC')->get();
            $data['totalBorrow'] = Borrowing::count();
            $data['onBorrow'] = Transaction::where('detail', 'borrow')->count();
            $data['totalOverdue'] = Transaction::where('detail', 'borrow')->where('due_date', '<', Carbon::now())->count();
            $data['totalBooks'] = Book::count();
            $data['borrowPercentage'] = round(($data['onBorrow'] / $data['totalBooks']) * 100);
            $data['monthlyLabel'] = Transaction::select(DB::raw('MONTHNAME(created_at) as month, COUNT(*) as count'))->groupBy(DB::raw('MONTH(created_at)'))->pluck('month');
            $data['monthlyData'] = Transaction::select(DB::raw('MONTHNAME(created_at) as month, COUNT(*) as count'))->groupBy(DB::raw('MONTH(created_at)'))->pluck('count');
            $data['topBooks'] = Book::select('books.title', DB::raw('COUNT(transactions.id) as count'), DB::raw('CAST(SUM(extended_count) AS INT) as extended'), DB::raw('COUNT(waitings.book_id) as waiting'), DB::raw('COUNT(*) + CAST(SUM(extended_count) AS integer) + COUNT(waitings.book_id) as total'))->leftJoin('items', 'items.book_id', '=', 'books.id')->leftJoin('transactions', 'transactions.item_id', '=', 'items.id')->leftJoin('waitings', 'waitings.book_id', '=', 'books.id')->groupBy('books.id')->orderBy('total', 'DESC')->take(5)->get();

            return view('dashboard', $data);
        } else {
            # code...
            $user = Auth::user();

            //header
            $data['title'] = 'Selamar Datang, '.$user->name;
            $data['desc'] = 'Berikut adalah informasi singkat mengenai akun anda dan daftar buku yang tersedia di perpustakaan';

            // dd(Auth::user()->id);
            

            //data
            $data['transactions'] = Transaction::where('user_id', $user->id)->get();
            $data['returnings'] = Returning::select('returnings.*')->join('transactions', 'transactions.id', '=', 'returnings.transaction_id')->where('transactions.user_id', $user->id)->get();
            $data['books'] = Book::all();
            $data['categories'] = Category::all();

            return view('member.booklist', $data);
        }
    }
}
