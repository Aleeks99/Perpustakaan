<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Petugas';
        $data['desc'] = 'Berisi daftar petugas perpustakaan';

        //data
        $data['users'] = User::role('librarian')->get();

        return view('staff.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //header
        $data['title'] = 'Tambah Petugas';
        $data['desc'] = 'Menambahkan petugas baru';

        return view('staff.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'gender' => $request->get('gender'),
                'address' => $request->get('address'),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ]);
    
            $user->assignRole('librarian');

            $notification = array(
                'message' => 'Petugas telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/staff')->with($notification);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $staff)
    {
        //header
        $data['title'] = 'Edit Petugas';
        $data['desc'] = 'Merubah informasi petugas';
        
        //data
        $data['user'] = $staff;
        
        return view('staff.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStaffRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, User $user)
    {
        try {
            User::find($request->get('id'))->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'gender' => $request->get('gender'),
                'address' => $request->get('address'),
            ]);
    
            $notification = array(
                'message' => 'Petugas telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/staff')->with($notification);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $staff)
    {
        try {
            User::destroy($staff->id);
            $notification = array(
                'message' => 'Petugas telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/staff')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return redirect('/staff')->with($notification);
        }
    }
}
