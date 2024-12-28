<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Returning;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Profil';
        $data['desc'] = 'Berisi informasi pengguna';

        //data
        $data['borrow'] = Borrowing::where('user_id', Auth::user()->id)->count();
        $data['return'] = Returning::where('user_id', Auth::user()->id)->count();

        return view('profile', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getname(Request $request, $id)
    {
        $user_name = User::find($id)->name;
        
        // return response()->json([
        //     'success' => 'yes',
        // ]);

        $data['name'] = $user_name;
    
        echo json_encode($data);
        exit;
    }
}
