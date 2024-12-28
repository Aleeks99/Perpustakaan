<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Book;
use App\Models\Items;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Buku';
        $data['desc'] = 'Berisi daftar buku perpustakaan';

        //data
        $data['books'] = Book::all();
        $data['items'] = Items::select('items.inv_id', 'books.isbn', 'books.title', DB::raw('CASE items.status WHEN "available" THEN "tersedia" WHEN "borrowed" THEN "tidak tersedia" END AS status'))->join('books', 'books.id', '=', 'items.book_id')->orderBy('books.title', 'ASC')->get();
        $data['categories'] = Category::all();
        // dd($data['items']);

        return view('collection.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //header
        $data['title'] = 'Tambah Buku';
        $data['desc'] = 'Menambahkan buku baru';

        //data
        $data['categories'] = Category::all();

        return view('collection.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        try {
            Book::create([
                'title' => $request->get('title'),
                'author' => $request->get('author'),
                'publisher' => $request->get('publisher'),
                'published_at' => $request->get('year'),
                'category_id' => $request->get('category'),
                'ISBN' => $request->get('isbn'),
                'description' => $request->get('description'),
            ]);

            $notification = array(
                'message' => 'Buku telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/books')->with($notification);
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //header
        $data['title'] = $book->title;
        $data['desc'] = $book->category->name;

        //data
        $data['book'] = $book;
        $data['items'] = Items::where('book_id', $book->id)->get();
        $data['categories'] = Category::all();

        return view('collection.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //header
        $data['title'] = 'Edit Buku';
        $data['desc'] = 'Merubah informasi buku';

        //data
        $data['book'] = $book;
        $data['categories'] = Category::all();

        return view('collection.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            Book::find($request->get('id'))->update([
                'title' => $request->get('title'),
                'author' => $request->get('author'),
                'publisher' => $request->get('publisher'),
                'published_at' => $request->get('year'),
                'category_id' => $request->get('category'),
                'ISBN' => $request->get('isbn'),
                'description' => $request->get('description'),
            ]);

            $notification = array(
                'message' => 'Buku telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/books/'.$request->get('id'))->with($notification);
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        try {
            Book::destroy($book->id);
            $notification = array(
                'message' => 'Buku telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/books')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return redirect('/books')->with($notification);
        }
    }
}
