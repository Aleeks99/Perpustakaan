<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Pengaturan';

        //data
        $data['settings'] = Setting::all();

        return view('setting.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSettingRequest  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, $id)
    {
        // dd($request->get('setting'));
        try {
            Setting::find($id)->update([
                'value' => $request->get('setting')
            ]);
            $notification = array(
                'message' => 'Pengaturan telah berhasil dirubah',
                'alert' => 'success'
            );
            return redirect('/setting')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert' => 'error'
            );
            return back()->with($notification);
        }
    }
}
