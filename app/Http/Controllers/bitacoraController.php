<?php

namespace App\Http\Controllers;

use App\bitacora;
use Illuminate\Http\Request;

class bitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    public function index()
    {
        return view("bitacora");
    }

    public function indexGet()
    {

        $bitacora=bitacora::Join("users", "bitacora.user_id","=","users.id")->/*where('users.id',"!=",'0')->*/select('users.name','users.is_admin','bitacora.updated_at','bitacora.id','bitacora.actions','bitacora.description', 'bitacora.model')->get();
       
        return json_encode($bitacora);
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
     * @param  \App\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function show(bitacora $bitacora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function edit(bitacora $bitacora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bitacora $bitacora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function destroy(bitacora $bitacora)
    {
        //
    }
}
