<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $data = array('title' => 'Profil User',
                    'itemuser' => $itemuser);
        
        if ($itemuser->role == 'admin') {
            return view('user.index-admin', $data);
        } elseif ($itemuser->role == 'seller') {
            return view('user.index-seller', $data);
        } else {
            return view('user.index', $data);
        }
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
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required',
            'phone' => 'required',
        ]);

        $itemuser = User::findOrFail($id);
        $input = $request->all();
        $fileupload = $request->file('image');
        $folder = 'assets/images';
        $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);
        $input['foto'] = $itemgambar->url;
        if ($itemuser->update($input)) {
            return back()->with('success', 'Profil berhasil diupdate');
        } else {
            return back()->with('error', 'Profil gagal diupdate');
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
        //
    }

    public function setting() {
        $data = array('title' => 'Setting Profil');
        return view('user.setting', $data);
    }
}
