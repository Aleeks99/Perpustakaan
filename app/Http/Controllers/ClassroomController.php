<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Kelas';
        $data['desc'] = 'Berisi daftar kelas siswa';

        //data
        // $data['users'] = User::role('member')->get();
        $data['classrooms'] = Classroom::all();
        return view('classroom.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //header
        $data['title'] = 'Tambah Kelas';
        $data['desc'] = 'Menambahkan kelas baru';

        return view('classroom.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClassroomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassroomRequest $request)
    {
        try {
            $classroom = Classroom::create([
                'name' => $request->get('name')
            ]);
    
            $notification = array(
                'message' => 'Kelas telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/classroom')->with($notification);
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
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //header
        $data['title'] = 'Edit Kelas';
        $data['desc'] = 'Merubah informasi kelas';
        
        //data
        $data['classroom'] = $classroom;
        
        return view('classroom.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClassroomRequest  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassroomRequest $request, Classroom $classroom)
    {
        try {  
            Classroom::find($classroom->id)->update([
                'name' => $request->get('name')
            ]);
    
            $notification = array(
                'message' => 'Kelas telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/classroom')->with($notification);
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
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        try {
            Classroom::destroy($classroom->id);
            $notification = array(
                'message' => 'Kelas telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/classroom')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return redirect('/classroom')->with($notification);
        }
    }
}
