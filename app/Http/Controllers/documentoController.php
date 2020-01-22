<?php

namespace App\Http\Controllers;
use DB;
use App\documento;
use App\modulo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Auth;

class documentoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("documentos");
    }

    public function indexGetPublic($modulos_id)
    {

        $documentos=documento::where('modulos_id', $modulos_id)->join('users','documentos.user_id',"=","users.id")->join('modulos','documentos.modulos_id', "=","modulos.id")->select('documentos.id',
            'documentos.codigo',
            'documentos.tipo',
            'documentos.id',
            'documentos.dirlocal',
            'documentos.fecha',
            'documentos.description',
            'users.id as user_id',
            'users.is_admin as user_is_admin','users.name',"modulos.row1","modulos.row2","modulos.row3","modulos.row4")->get();




            return json_encode($documentos);
    }

    public function indexGet($modulos_id)
    {
       /* $result= DB::table("documentos")->join("users","documentos.user_id", "=","users.id")->get("users.email");


       $a= documento::with(['User'=> function($query)
       {
            $query->select(['users.id','users.name']);
        }])
        ->get(['id','dirlocal','user_id']);
        */

        if(Auth::user()->is_admin==true)
        {
            $documentos=documento::where('modulos_id', $modulos_id)->join('users','documentos.user_id',"=","users.id")->join('modulos','documentos.modulos_id', "=","modulos.id")->select('documentos.id',
            'documentos.codigo',
            'documentos.tipo',
            'documentos.id',
            'documentos.dirlocal',
            'documentos.fecha',
            'documentos.description',
            'users.id as user_id',
            'users.is_admin as user_is_admin',
            'users.name',"modulos.nombre")->get();

            //$modulos=modulo::where('id', $modulos_id)->select("modulos.row1","modulos.row2","modulos.row3","modulos.row4")->get()


            return json_encode($documentos);
        }

      /*  $documentos = documento::where('modulos_id', $modulos_id)->get();


        return json_encode($documentos);*/
    }



    public function indexGetMobile()
    {
       /* $result= DB::table("documentos")->join("users","documentos.user_id", "=","users.id")->get("users.email");


       $a= documento::with(['User'=> function($query)
       {
            $query->select(['users.id','users.name']);
        }])
        ->get(['id','dirlocal','user_id']);
        */


            // $documentos=documento::join('users','documentos.user_id',"=","users.id")->join('modulos','documentos.modulos_id', "=","modulos.id")->select('documentos.id',
            // 'documentos.codigo',
            // 'documentos.tipo',
            // 'documentos.id',
            // 'documentos.fecha',
            // 'documentos.description',
            // "modulos.nombre")->get();

            $documentos=documento::join('users','documentos.user_id',"=","users.id")->join('modulos','documentos.modulos_id', "=","modulos.id")->select(
            'documentos.codigo as Code',
            'documentos.tipo as Type',
            'documentos.id as ID',
            'documentos.fecha as Date',
            'documentos.description as Description',
            "modulos.nombre as Module",
            'documentos.updated_at as Modified',
            'documentos.created_at as Created',
            'documentos.views as Views')->get();

            //$modulos=modulo::where('id', $modulos_id)->select("modulos.row1","modulos.row2","modulos.row3","modulos.row4")->get()


            return json_encode($documentos);


      /*  $documentos = documento::where('modulos_id', $modulos_id)->get();


        return json_encode($documentos);*/
    }












    public function indexGetAll()
    {

        return view("guest");

    }

    public function indexGetFirst()
    {

        //$modulo=modulo::first();
        if(Auth::user()->is_admin==false)
        {//->join('modulos','users.modulos_id_u',"=","modulos.id")
            $documentos=documento::where('modulos_id', Auth::user()->modulos_id_u)->join('modulos','documentos.modulos_id',"=","modulos.id")->join('users','documentos.user_id',"=","users.id")->select(
                'documentos.id',
                'documentos.codigo',
                'documentos.tipo',
                'documentos.id',
                'documentos.dirlocal',
                'documentos.fecha',
                'documentos.description',
                'users.id as user_id',
                'users.is_admin as user_is_admin',
                'users.name','modulos.nombre','modulos.id as moduloId', "modulos.row1", "modulos.row2", "modulos.row3", "modulos.row4")->get();


                $a=$documentos[0]->moduloId;

                return json_encode(["success"=>true, "documentos"=>$documentos, "user_is_admin"=>Auth::user()->is_admin, "moduloId"=>$a, "row1"=>$documentos[0]->row1,"row2"=>$documentos[0]->row2,"row3"=>$documentos[0]->row3,"row4"=>$documentos[0]->row4]);
        }
        else
        {
        $documentos=documento::/*where('modulos_id', $modulo->id)->*/join('users','documentos.user_id',"=","users.id")->select(
            'documentos.id',
            'documentos.codigo',
            'documentos.tipo',
            'documentos.id',
            'documentos.dirlocal',
            'documentos.fecha',
            'documentos.description',
            'users.id as user_id',
            'users.is_admin as user_is_admin',
            'users.name')->get();


            return json_encode(["success"=>true,"user_is_admin"=>Auth::user()->is_admin, "documentos"=>$documentos]);

        }


    }



    public function indexGetFirstPublic()
    {

        $modulo=modulo::first();
        $documentos=documento::where('modulos_id', $modulo->id)->join('users','documentos.user_id',"=","users.id")->join('modulos','documentos.modulos_id', "=","modulos.id")->select('documentos.id',
        'documentos.codigo',
        'documentos.tipo',
        'documentos.id',
        'documentos.modulos_id',
        'documentos.dirlocal',
        'documentos.fecha',
        'documentos.description',
        'modulos.nombre',
        'users.id as user_id',
        'users.is_admin as user_is_admin','users.name',"modulos.row1","modulos.row2","modulos.row3","modulos.row4")->get();






            return json_encode(["success"=>true, "documentos"=>$documentos]);




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

        if(!Auth::User()->is_admin)
        {
            $request->validate([
                'description' => 'regex:/^([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|max:200',

                'dirlocal' => 'required',
                'tipo' => 'integer',
                'codigo' => 'regex:/^[0-9]+$/|unique:documentos,codigo,',
                'fecha' => 'date',

            ]);
            $request->modulos_id = Auth::User()->modulos_id_u;
        }

        else{
            $request->validate([
                'description' => 'regex:/^([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|max:200',
                'modulos_id' => 'required|numeric',
                'dirlocal' => 'required',
                'tipo' => 'integer',
                'codigo' => 'regex:/^[0-9]+$/|unique:documentos,codigo,',
                'fecha' => 'date',

            ]);
        }


        if ($request->hasFile('dirlocal'))
        {






            $file = $request->file('dirlocal');
            $imagedata = file_get_contents($file);
            $b64doc = base64_encode($imagedata);
            /*

            $name = time().$file->getClientOriginalName();
            $file->move(public_path()."/pdf", $name);
            */


        }



        $documento = new documento;
        $documento->description = stripslashes(htmlspecialchars($request->description));
        $documento->modulos_id = $request->modulos_id;

        $documento->pdf = $b64doc;

        $documento->codigo = stripslashes(htmlspecialchars($request->codigo));

        $documento->tipo = stripslashes(htmlspecialchars($request->tipo));
        $documento->fecha = $request->fecha;
        //$documento->dirlocal = $name;

        if(!Auth::User()->is_admin)
        {
            $documento->modulos_id = Auth::User()->modulos_id_u;
        }



        $documento->user_id = Auth::user()->id;

        $documento -> save();
        $documento->name = Auth::user()->name;
        $documento->user_is_admin = Auth::user()->is_admin;
        return json_encode(['success' => true, 'documento'=>$documento]);

        /*return redirect()->route('modulos.index');*/
    }

    public function getModulo($modulos_id)
    {
        $documentos = documento::all();

        return json_encode($documentos);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\documento  $documento
     * @return \Illuminate\Http\Response
     */



        /* $documento = documento::find($id);
        $pdfName = str_random(10).'.'.'pdf';
        \File::put(public_path(). '//pdf//' . $pdfName, base64_decode($documento->pdf));
        return redirect("pdf//".$pdfName);
        */



    public function generatePdf($id)
    {

        $documento = documento::find($id);
        $pdfName = $id.'.pdf';
        $documento->views=$documento->views+1;

        $documento->save();
        //$doczip=(gzdeflate($documento->pdf));

        // $compressed = gzdeflate($documento->pdf,  9);
        // $compressed = gzdeflate($compressed, 9);
        // dd(strlen($compressed));
        if (!file_exists(public_path(). '//pdf//' . $pdfName)) {
            \File::put(public_path(). '//pdf//' . $pdfName, base64_decode($documento->pdf));
        }
        return redirect("pdf//".$pdfName);


        //return json_encode([ 'data' => $documento->pdf]);
       //return response()->download("pdf//".$pdfName)->deleteFileAfterSend(true);

        /*
        $pdffile=base64_decode($documento->pdf);
        $data="a";
        return view('pdfviewer',[ 'data' => $documento->pdf]);*/

    }


    public function generatePdfMobile($id)
    {

        $documento = documento::find($id);
        $documento->views=$documento->views+1;
        $counter=$documento->views;
        $documento->save();
        $pdfName = $id.'.pdf';
        //$doczip=(gzdeflate($documento->pdf));

        // $compressed = gzdeflate($documento->pdf,  9);
        // $compressed = gzdeflate($compressed, 9);
        // dd(strlen($compressed));
        if (!file_exists(public_path(). '//pdf//' . $pdfName)) {
            \File::put(public_path(). '//pdf//' . $pdfName, base64_decode($documento->pdf));
        }
        return json_encode(['success' => true, 'uri' => 'pdf', "name"=>$pdfName]);

        //return json_encode([ 'data' => $documento->pdf]);
       //return response()->download("pdf//".$pdfName)->deleteFileAfterSend(true);

        /*
        $pdffile=base64_decode($documento->pdf);
        $data="a";
        return view('pdfviewer',[ 'data' => $documento->pdf]);*/

    }


    public function show($id)
    {
        $documento = documento::find($id);
        if(Auth::user()->is_admin==true)
        {

            return json_encode(['success' => true, 'documento' => $documento, "is_admin"=>Auth::User()->is_admin]);
        }
        else if($documento->user_id==Auth::user()->id)
        {

            return json_encode(['success' => true, 'documento' => $documento, "is_admin"=>Auth::User()->is_admin]);
        }
        else{
            return json_encode(['invalid_user' => true]);
        }








    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(documento $documento)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $pdfName = $id.'.pdf';





        $documento = documento::find($id);


        $request->validate([
            'description' => 'regex:/^([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-Z,.ñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|max:200',
            'codigo' => 'regex:/^[0-9]+$/',
            'fecha' => 'date',
            'tipo' => 'integer',
            "codigo" => 'regex:/^[0-9]+$/|unique:documentos,codigo,'.$documento->id
        ]);

        $documento->description = stripslashes(htmlspecialchars($request->description));


        if ($request->hasFile('dirlocal'))
        {
            $file = $request->file('dirlocal');
            $imagedata = file_get_contents($file);
            $b64doc = base64_encode($imagedata);
            $documento->pdf = $b64doc;

        }




        $documento->codigo = stripslashes(htmlspecialchars($request->codigo));
        $documento->tipo = stripslashes(htmlspecialchars($request->tipo));
        $documento->fecha = stripslashes(htmlspecialchars($request->fecha));


        $documentos=$documento->user;

        if(Auth::user()->is_admin==true)
        {
            if (file_exists(public_path(). '//pdf//' . $pdfName)) {
                unlink(public_path(). '//pdf//' . $pdfName);
            }
            $documento -> save();
            return json_encode(['success' => true,"documento"=>$documento, 'user'=>$documentos]);
        }
        else if($documento->user_id==Auth::user()->id)
        {
            if (file_exists(public_path(). '//pdf//' . $pdfName)) {
                unlink(public_path(). '//pdf//' . $pdfName);
            }
            $documento -> save();
            return json_encode(['success' => true,"documento"=>$documento, 'user'=>$documentos]);
        }
        else{
            return json_encode(['invalid_user' => true]);
        }






    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(documento $documento)
    {
        $pdfName = $documento->id.'.pdf';
        $documento->user_id;
        if(Auth::user()->is_admin==true)
        {
            if (file_exists(public_path(). '//pdf//' . $pdfName)) {
                unlink(public_path(). '//pdf//' . $pdfName);
            }

            $documento->delete();
            return json_encode(['success' => true]);
        }
        else if($documento->user_id==Auth::user()->id)
        {
            /*public function destroy($id){
      $data = User::FindOrFail($id);
      if(file_exists('backend_assets/uploads/userPhoto/'.$data->photo) AND !empty($data->photo)){
            unlink('backend_assets/uploads/userPhoto/'.$data->photo);
         }
            try{

                $data->delete();
                $bug = 0;
            }
            catch(\Exception $e){
                $bug = $e->errorInfo[1];
            }
            if($bug==0){
                echo "success";
            }else{
                echo 'error';
            }
        }*/
        if (file_exists(public_path(). '//pdf//' . $pdfName)) {
            unlink(public_path(). '//pdf//' . $pdfName);
        }
            $documento->delete();
            return json_encode(['success' => true]);
        }
        else{
            return json_encode(['invalid_user' => true]);
        }



    }
}
