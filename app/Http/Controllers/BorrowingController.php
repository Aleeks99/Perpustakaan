<?php

namespace App\Http\Controllers;

use App\Models\borrowing;
use App\Http\Requests\StoreborrowingRequest;
use App\Http\Requests\UpdateborrowingRequest;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreborrowingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreborrowingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function show(borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function edit(borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateborrowingRequest  $request
     * @param  \App\Models\borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateborrowingRequest $request, borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\borrowing  $borrowing
     * @return \Illuminate\Http\Response
     */
    public function destroy(borrowing $borrowing)
    {
        //
    }
}
