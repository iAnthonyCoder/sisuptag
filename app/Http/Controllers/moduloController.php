<?php

namespace App\Http\Controllers;
use DB;
use App;
use App\modulo;
use Illuminate\Http\Request;

class moduloController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modulos');
    }

    public function indexGet()
    {
        $modulos=modulo::leftjoin("documentos", "modulos.id","=","documentos.modulos_id")->/*where('users.id',"!=",'0')->*/groupBy('modulos.id')->select('modulos.descripcion','modulos.id','modulos.nombre',"modulos.row1","modulos.row2","modulos.row3","modulos.row4", DB::raw("COUNT(documentos.id) as documentos_publicados_m"))->get();
        return json_encode($modulos);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|unique:modulos,nombre',
            'descripcion' => 'required|regex:/^([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|max:200',
        ]);
        $count=Modulo::count();
        if($count>10)
        {
            return json_encode(['fullmodule' => true]);
        }
        $modulo = new modulo;
        $modulo->nombre = stripslashes(htmlspecialchars($request->nombre));
        $modulo->descripcion = stripslashes(htmlspecialchars($request->descripcion));
        if($request->row1=="on"){$modulo->row1 = 1;}else{$modulo->row1 = 0;}
        if($request->row2=="on"){$modulo->row2 = 1;}else{$modulo->row2 = 0;}
        if($request->row3=="on"){$modulo->row3 = 1;}else{$modulo->row3 = 0;}
        if($request->row4=="on"){$modulo->row4 = 1;}else{$modulo->row4 = 0;}

        $saved = $modulo -> save();
        if(!$saved)
        {
            App::abort(500, 'Ocurrió algun error. Reporte en la brevedad.');
        }
        else
        {
            return json_encode(['success' => true, 'modulo'=>$modulo]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modulo = modulo::find($id);

        return json_encode(['success' => true, 'modulo' => $modulo]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function edit(modulo $modulo)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $modulo = modulo::find($id);

        $request->validate([
            'nombre' => 'required|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|unique:modulos,nombre,'.$modulo->id,
            'descripcion' => 'required|regex:/^([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|max:200',
        ]);

        $modulo->nombre = stripslashes(htmlspecialchars($request->nombre));
        $modulo->descripcion = stripslashes(htmlspecialchars($request->descripcion));
        if($request->row1=="on"){$modulo->row1 = 1;}else{$modulo->row1 = 0;}
        if($request->row2=="on"){$modulo->row2 = 1;}else{$modulo->row2 = 0;}
        if($request->row3=="on"){$modulo->row3 = 1;}else{$modulo->row3 = 0;}
        if($request->row4=="on"){$modulo->row4 = 1;}else{$modulo->row4 = 0;}




        $modulo->save();
        return json_encode(['success' => true, 'modulo' => $modulo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(modulo $modulo)
    {
        if($modulo->documentos()->count()>0)
        {
            return json_encode(['error' => true]);
        }
        else if($modulo->documentos()->count()==0)
        {
            $modulo->delete();
            return json_encode(['success' => true]);
        }
    }
}
