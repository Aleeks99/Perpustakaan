<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Returning;
use App\Models\Transaction;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Anggota';
        $data['desc'] = 'Berisi daftar anggota perpustakaan';

        //data
        // $data['users'] = User::role('member')->get();
        $data['users'] = Student::all();
        return view('member.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //header
        $data['title'] = 'Tambah Anggota';
        $data['desc'] = 'Menambahkan anggota baru';
        $data['classrooms'] = Classroom::all();

        return view('member.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        try {
            $user = Student::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'gender' => $request->get('gender'),
                'address' => $request->get('address'),
                'nisn' => $request->get('nisn'),
                'classroom_id' => $request->get('classroom'),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' //default password "passoword"
            ]);
    
            $user->assignRole('member');
    
            $notification = array(
                'message' => 'Anggota telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/member')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //header
        $data['title'] = 'Anggota';
        $data['desc'] = 'Berisi daftar anggota perpustakaan';

        //data
        $data['student'] = Student::find($id);
        $data['transactions'] = Transaction::where('user_id', $data['student']->super->id)->get();
        $data['returnings'] = Returning::select('returnings.*')->join('transactions', 'transactions.id', '=', 'returnings.transaction_id')->where('transactions.user_id', $data['student']->super->id)->get();
        return view('member.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $member)
    {
        //header
        $data['title'] = 'Edit Anggota';
        $data['desc'] = 'Merubah informasi anggota';
        $data['classrooms'] = Classroom::all();
        
        //data
        $data['user'] = $member;

        return view('member.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        try {
            Student::find($request->get('id'))->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'gender' => $request->get('gender'),
                'address' => $request->get('address'),
                'nisn' => $request->get('nisn'),
                'classroom_id' => $request->get('classroom')
            ]);

            $notification = array(
                'message' => 'Anggota telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/member')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Student::destroy($id);
            $notification = array(
                'message' => 'Anggota telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/member')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return redirect('/member')->with($notification);
        }
    }

    public function showProfile($id)
    {
        //header
        $data['title'] = 'Profil';
        $data['desc'] = 'Berisi informasi pengguna';

        //data
        $data['student'] = Student::find(User::find($id)->userable_id);
        $data['transactions'] = Transaction::where('user_id', $id)->get();
        $data['returnings'] = Returning::select('returnings.*')->join('transactions', 'transactions.id', '=', 'returnings.transaction_id')->where('transactions.user_id', $id)->get();
        return view('member.show', $data);
    }
}
