<?php

namespace App\Http\Controllers;
use App\Models\Pertanian;
use Illuminate\Http\Request;

class Pertanians3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //$books = Book::all();
    $pertanians = Pertanian::paginate(100);

    return view('home.pertanian.layouts',[
     'pertanians' => $pertanians,
     'title' =>"Daftar Tanaman"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
