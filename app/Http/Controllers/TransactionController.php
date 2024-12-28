<?php

namespace App\Http\Controllers;

use DB;
use Datetime;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\ExtendBorrowingRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\Borrowing;
use App\Models\Returning;
use App\Models\Book;
use App\Models\Items;
use App\Models\User;
use App\Models\Student;
use App\Models\Setting;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;

class TransactionController extends Controller
{
    //
    public function index()
    {
        //header
        $data['title'] = 'Transaksi';
        $data['desc'] = 'Buat transaksi peminjaman disini';

        //data
        $data['book_items'] = Items::where('status', 'available')->get();
        $data['allbooks'] = Book::all();
        $data['students'] = Student::all();
        $data['transactions'] = Transaction::orderByDesc('created_at')->take(5)->get();
        $data['due_date'] = Setting::where('key', 'due_date')->first()->value;

        return view('transaction', $data);
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            Transaction::create([
                'user_id' => $request->get('memberID'),
                'item_id' => $request->get('bookID'),
                'due_date' => $request->get('date'),
                'detail' => 'borrow'
            ]);

            Borrowing::create([
                'transaction_id' => Transaction::latest()->first()->id,
                'user_id' => Auth::user()->id,
                'borrowed_at' => now()
            ]);

            Items::find($request->get('bookID'))->update([
                'status' => 'borrowed'
            ]);

            $notification = array(
                'message' => 'Buku telah berhasil dipinjam',
                'alert' => 'success'
            );
            return redirect('/transaction')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification)->withInput();
        }
    }

    public function showLog(Request $request)
    {
        $borrowing = Transaction::select('transactions.*', DB::raw('borrowings.created_at AS date_time'), DB::raw("'borrow' AS detail"))->join('borrowings', 'borrowings.transaction_id', '=', 'transactions.id');
        $returning = Transaction::select('transactions.*', DB::raw('returnings.created_at AS date_time'), DB::raw("'return' AS detail"))->join('returnings', 'returnings.transaction_id', '=', 'transactions.id');
        $filter = 'all';

        $validator = Validator::make($request->all(), [
            'filter' => 'required'
        ]);

        if ($validator->passes()) {
            switch ($request->get('filter')) {
                case 'all':
                    $filter = 'all';
                    break;

                case 'today':
                    $borrowing = $borrowing->where('borrowings.created_at', 'LIKE', date('Y-m-d') . '%');
                    $returning = $returning->where('returnings.created_at', 'LIKE', date('Y-m-d') . '%');
                    $filter = 'today';
                    break;

                case 'this_month':
                    $borrowing = $borrowing->where('borrowings.created_at', 'LIKE', date('Y-m') . '%');
                    $returning = $returning->where('returnings.created_at', 'LIKE', date('Y-m') . '%');
                    $filter = 'this_month';
                    break;

                default:
                    $filter = 'all';
                    break;
            }
        }

        //header
        $data['title'] = 'Riwayat Transaksi';
        $data['desc'] = 'Berisi daftar riwayat transaksi peminjaman dan pengembalian';

        //data
        $data['books'] = Book::all();
        $data['users'] = User::all();
        $tx = $borrowing->union($returning)->orderBy('date_time', 'DESC')->get();
        $data['transactions'] = $tx;
        $data['filter'] = $filter;

        return view('log', $data);
    }

    public function refresh(Request $request)
    {
        $borrowing = Transaction::select('transactions.*', DB::raw('borrowings.created_at AS date_time'), DB::raw("'borrow' AS detail"))->join('borrowings', 'borrowings.transaction_id', '=', 'transactions.id');
        $returning = Transaction::select('transactions.*', DB::raw('returnings.created_at AS date_time'), DB::raw("'return' AS detail"))->join('returnings', 'returnings.transaction_id', '=', 'transactions.id');

        if (request()->ajax()) {
            $data = $borrowing->union($returning)->orderBy('date_time', 'DESC')->get();

            $validator = Validator::make($request->all(), [
                'filter' => 'required'
            ]);

            switch ($request->get('filter')) {
                case 'all':
                    $data = $borrowing->union($returning)->orderBy('date_time', 'DESC')->get();
                    break;

                case 'today':
                    $new_borrowing = $borrowing->where('borrowings.created_at', 'LIKE', date('Y-m-d') . '%');
                    $new_returning = $returning->where('returnings.created_at', 'LIKE', date('Y-m-d') . '%');
                    $data = $new_borrowing->union($new_returning)->orderBy('date_time', 'DESC')->get();
                    break;

                case 'this_month':
                    $new_borrowing = $borrowing->where('borrowings.created_at', 'LIKE', date('Y-m') . '%');
                    $new_returning = $returning->where('returnings.created_at', 'LIKE', date('Y-m') . '%');
                    $data = $new_borrowing->union($new_returning)->orderBy('date_time', 'DESC')->get();
                    break;

                default:
                    $data = $borrowing->union($returning)->orderBy('date_time', 'DESC')->get();
                    break;
            }

            if ($validator->passes()) {
                return response()->json([
                    'msg' => 'Updated Successfully',
                    'success' => true,
                    'data' => $data,
                    'filter' => $request->get('filter')
                ]);
            }
            return response()->json(['msg' => $validator->errors()->all()]);
        }
        // return view('return', $data);
    }

    public function borrowedlist()
    {
        //header
        $data['title'] = 'Peminjaman';
        $data['desc'] = 'Berisi daftar peminjaman buku';

        //data
        $data['books'] = Book::all();
        $data['users'] = User::all();
        $data['borrowings'] = Borrowing::all();
        $data['transactions'] = Transaction::where('detail', '=', 'borrow')->orderBy('created_at', 'DESC')->get();
        $data['fee'] = Setting::where('key', 'fee')->first()->value;

        return view('return', $data);
    }

    public function return(Request $request, $id)
    {
        try {
            //
            $transaction = Transaction::find($id);
            $fee = Setting::where('key', 'fee')->first()->value;
            $due_date = $transaction->due_date; // the date that the task is due
            $today = date("Y-m-d"); // the current date

            if ($today > $due_date) {
                $start_date = new DateTime($due_date); // the start date
                $end_date = new DateTime($today); // the end date

                // use the diff() method to get the difference between the two dates
                $diff = $start_date->diff($end_date);

                // use the d property to get the number of days
                $days = $diff->d;
                $fee = $days * $fee;

                Returning::create([
                    'transaction_id' => $id,
                    'user_id' => Auth::user()->id,
                    'returned_date' => now(),
                    'detail' => 'overdue',
                    'fine_fee' => $fee
                ]);
            } else {
                Returning::create([
                    'transaction_id' => $id,
                    'user_id' => Auth::user()->id,
                    'returned_date' => now(),
                    'detail' => 'due',
                    'fine_fee' => 0
                ]);
            }

            Transaction::find($id)->update(['detail' => 'return']);

            Items::find($transaction->item_id)->update([
                'status' => 'available'
            ]);

            $notification = array(
                'message' => 'Buku telah berhasil dikembalikan',
                'alert' => 'success'
            );
            return redirect('/return')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function extend(ExtendBorrowingRequest $request, $id)
    {
        try {
            // $validated = $request->validate([
            //     'old_date' => 'required|date',
            //     'date' => 'required|date|after:' . $request->get('old_date')
            // ]);

            Transaction::find($id)->update([
                'due_date' => $request->get('date'),
            ]);

            Transaction::find($id)->increment('extended_count', 1);

            return redirect('/return')->with('success', 'Extend success!');

            $notification = array(
                'message' => 'Masa peminjaman telah berhasil diperpanjang',
                'alert' => 'success'
            );
            return redirect('/return')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification)->withInput();
        }
    }
}
