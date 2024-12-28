<?php

namespace App\Http\Controllers;

use App\Models\Waiting;
use App\Models\Book;
use App\Models\User;
use App\Http\Requests\StoreWaitingRequest;
use App\Http\Requests\UpdateWaitingRequest;

class WaitingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = 'Waitlist';
        $data['desc'] = 'Contains a list of members';
        $data['books'] = Book::all();
        $data['users'] = User::all();
        $data['waitings'] = Waiting::all();
        return view('waitlist', $data);
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
     * @param  \App\Http\Requests\StoreWaitingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWaitingRequest $request)
    {
        //
        $validated = $request->validate([
            'bookID' => 'required',
            'memberID' => 'required'
        ]);

        Waiting::create([
            'user_id' => $validated['memberID'],
            'book_id' => $validated['bookID']
        ]);

        return redirect('/transaction')->with('success', 'Create success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function show(Waiting $waiting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiting $waiting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWaitingRequest  $request
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWaitingRequest $request, Waiting $waiting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiting $waiting)
    {
        //
    }
}
