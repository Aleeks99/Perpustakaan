<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //header
        $data['title'] = 'Kategori';
        $data['desc'] = 'Berisi daftar kategori buku';

        //data
        $data['categories'] = Category::all();

        return view('category.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //header
        $data['title'] = 'Tambah Kategori';
        $data['desc'] = 'Menambahkan kategori baru';

        return view('category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            Category::create([
                'name' => $request->get('name'),
            ]);
            $notification = array(
                'message' => 'Kategori telah berhasil ditambahkan',
                'alert' => 'success'
            );
            return redirect('/category')->with($notification);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //header
        $data['title'] = 'Edit Kategori';
        $data['desc'] = 'Merubah informasi kategori';

        //data
        $data['category'] = $category;
        return view('category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            Category::find($category->id)->update([
                'name' => $request->get('name')
            ]);

            $notification = array(
                'message' => 'Kategori telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/category')->with($notification);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            Category::destroy($category->id);
            $notification = array(
                'message' => 'Kategori telah berhasil dihapus',
                'alert' => 'success'
            );
            return redirect('/category')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return redirect('/category')->with($notification);
        }
    }
}
