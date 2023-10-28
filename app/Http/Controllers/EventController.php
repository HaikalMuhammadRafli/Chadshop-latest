<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemevent = Event::orderBy('created_at', 'desc')->paginate(20);
        $data = array('title' => 'Event Diskon',
                    'itemevent' => $itemevent);
        return view('event.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array('title' => 'Form Event');
        return view('event.create', $data);
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
            'kode_event' => 'required|unique:event',
            'nama_event' => 'required',
            'slug_event' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);

        $itemuser = $request->user();
        $input = $request->all();
        $input['user_id'] = $itemuser->id;
        $input['slug_event'] = \Str::slug($request->slug_event);
        $input['status'] = 'nonaktif';

        $fileupload = $request->file('image');
        $folder = 'assets/images';
        $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);

        $input['banner'] = $itemgambar->url;
        $itemevent = Event::create($input);
        return redirect()->route('event.index')->with('success', 'Event berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemevent = Event::findOrFail($id);

        $data = array('title' => 'Form Edit Event',
                        'itemevent' => $itemevent);
        return view('event.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_event'=>'required',
            'slug_event' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);
        $itemuser = $request->user();
        $itemevent = Event::findOrFail($id);
        $slug = \Str::slug($request->slug_event);
        $validasislug = Event::where('id', '!=', $id)
                                ->where('slug_event', $slug)
                                ->first();
        if ($validasislug) {
            return back()->with('error', 'Slug sudah ada, coba yang lain');
        } else {
            $input = $request->all();
            $input['slug'] = $slug;
            $fileupload = $request->file('image');
            $folder = 'assets/images';
            $itemgambar = (new ImageController)->upload($fileupload, $itemuser, $folder);
            $input['banner'] = $itemgambar->url;
            $itemevent->update($input);
            return redirect()->route('event.index')->with('success', 'Event berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemevent = Event::findOrFail($id);

        if ($itemevent->banner != null) {
            \Storage::delete($itemevent->banner);
        }
        if (is_countable($itemevent->eventdetail) && count($itemevent->eventdetail) > 0) {
            return back()->with('error', 'Hapus dulu produk di dalam event ini, proses dihentikan');
        } else {
            if ($itemevent->delete()) {
                return back()->with('success', 'Event berhasil dihapus');
            } else {
                return back()->with('error', 'Event gagal dihapus');
            }
        }
    }
}
