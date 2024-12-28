<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemsRequest;
use App\Http\Requests\UpdateItemsRequest;

class ItemsController extends Controller
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
     * @param  \App\Http\Requests\StoreItemsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemsRequest $request)
    {
        try {
            Items::create([
                'inv_id' => $request->get('inv_number'),
                'book_id' => $request->get('id'),
                'status' => 'available'
            ]);

            $notification = array(
                'message' => 'Item buku telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/books/'.$request->get('id'))->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            dd($th->getMessage());
            return back()->with($notification)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemsRequest  $request
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemsRequest $request, Items $items)
    {
        try {
            Items::find($request->get('id'))->update([
                'inv_id' => $request->get('inv_number'),
                'book_id' => $request->get('book_id')
            ]);

            $notification = array(
                'message' => 'Item buku telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/books/'.$request->get('book_id'))->with($notification);
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
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $items = Items::find($id);
            Items::destroy($items->id);
            $notification = array(
                'message' => 'Item buku telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/books/'.$items->book_id)->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification);
        }
    }
}
