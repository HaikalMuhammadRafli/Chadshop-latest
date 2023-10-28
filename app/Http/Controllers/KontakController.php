<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemkontak = Kontak::orderBy('created_at', 'desc')->paginate(15);

        $data = array(
            'title' => 'Kontak',
            'itemkontak' => $itemkontak,
        );
        return view('kontak.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array('title' => 'Form Kontak');
        return view('kontak.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'peran' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $input = $request->all();
        $kontak = Kontak::create($input);

        if ($kontak) {
            return redirect('admin/kontak')->with('success', 'Kontak berhasil ditambahkan!');
        } else {
            return redirect('admin/kontak')->with('error', 'Kontak gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kontak  $kontak
     * @return \Illuminate\Http\Response
     */
    public function show(Kontak $kontak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kontak  $kontak
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemkontak = Kontak::findOrFail($id);

        $data = array('title' => 'Form Edit Kontak',
                    'itemkontak' => $itemkontak);
        return view('kontak.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kontak  $kontak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'peran' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $itemkontak = Kontak::findOrFail($id);
        $input = $request->all();
        if ($itemkontak->update($input)) {
            return redirect('admin/kontak')->with('success', 'Kontak berhasil diupdate!');
        } else {
            return redirect('admin/kontak')->with('error', 'Kontak gagal diupdate!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kontak  $kontak
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemkontak = Kontak::findOrFail($id);
        if ($itemkontak->delete()) {
            return back()->with('success', 'Kontak berhasil dihapus!');
        } else {
            return back()->with('error', 'Kontak gagal dihapus!');
        }
    }
}
