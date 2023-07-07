<?php

namespace App\Http\Controllers;
use App\Models\Pertanian;
use Illuminate\Http\Request;

class PertaniansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //$books = Book::all();
       $pertanians = Pertanian::paginate(100);

       return view('admin.layouts.dashboard',[
        'pertanians' => $pertanians,
        'title' =>"Daftar Tanaman"]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pertanians.create',[
        "title"=>"Tambah Data Tanaman"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tanaman' => 'required',
            'luas_tanam' => 'required',
            'luas_panen' => 'required',
            'daerah_penghasil' => 'required',
            'harga_jual' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required'
        ]);
    
        // Simpan foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('storage/foto'), $fotoName);
            $fotoPath = 'storage/foto/' . $fotoName;
        }
    
        // Simpan data pertanian
        Pertanian::create([
            'nama_tanaman' => $request->input('nama_tanaman'),
            'luas_tanam' => $request->input('luas_tanam'),
            'luas_panen' => $request->input('luas_panen'),
            'daerah_penghasil' => $request->input('daerah_penghasil'),
            'harga_jual' => $request->input('harga_jual'),
            'foto' => $fotoPath,
            'deskripsi' => $request->input('deskripsi')
        ]);
    
        // Redirect
        return redirect()->route('pertanians.index')->with('success', 'pertanians added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pertanian $pertanian)
    {
        return view('admin.pertanians.show',[ 'pertanian' => $pertanian,
        "title"=>"Data Tanaman"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pertanian $pertanian)
    {
        return view('admin.pertanians.edit',[
            'pertanian'=>$pertanian,
            "title"=>"Edit Data Tanaman"
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_tanaman' => 'required',
            'luas_tanam' => 'required',
            'luas_panen' => 'required',
            'daerah_penghasil' => 'required',
            'harga_jual' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required'
        ]);
    
        // Ambil data pertanian yang akan diupdate
        $pertanian = Pertanian::findOrFail($id);
    
        // Simpan foto jika ada perubahan
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('storage/foto'), $fotoName);
            $fotoPath = 'storage/foto/' . $fotoName;
    
            // Hapus foto lama jika ada
            if ($pertanian->foto && file_exists(public_path($pertanian->foto))) {
                unlink(public_path($pertanian->foto));
            }
    
            $pertanian->foto = $fotoPath;
        }
    
        // Update data pertanian
        $pertanian->nama_tanaman = $request->input('nama_tanaman');
        $pertanian->luas_tanam = $request->input('luas_tanam');
        $pertanian->luas_panen = $request->input('luas_panen');
        $pertanian->daerah_penghasil = $request->input('daerah_penghasil');
        $pertanian->harga_jual = $request->input('harga_jual');
        $pertanian->deskripsi = $request->input('deskripsi');
        $pertanian->save();
    
        // Redirect
        return redirect()->route('pertanians.index')->with('success', 'Data tanaman berhasil diperbarui');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
