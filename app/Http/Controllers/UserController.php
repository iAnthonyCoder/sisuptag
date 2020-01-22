<?php

namespace App\Http\Controllers;
use Mail;
use Hash;
use Auth;
use App\User;
use Illuminate\Http\Request;

use Redirect,Response,DB,Config;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("users");
    }

    public function profile()
    {
        return view("profile");
    }

    public function indexGet()
    {


        //$users = user::all()->whereNotin('id', '0');

        $a= user::where('id',"!=",'0')->with(['documentos'=> function($query)
       {
            $query->count('id');
        }])
        ->get(['id','name']);

        $users=User::leftJoin("modulos","users.modulos_id_u","=","modulos.id")->leftjoin("documentos", "users.id","=","documentos.user_id")->/*where('users.id',"!=",'0')->*/groupBy('users.id')->select('users.id','users.name','users.email','users.is_admin','users.enabled',"modulos.nombre" , DB::raw("COUNT(documentos.id) as documentos_publicados"))->get();




        /*
        foreach ($users as $user) {
            if ($user->id != "0")
            {
                $request->id = $user->id;
                $request->name = $user->name;
                $request->email = $user->email;
                $request->is_admin = $user->is_admin;

            }

        }
        dd($request);*/

        return json_encode($users);
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

        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z]+$/u|max:20',
            'email' => 'required|email|unique:users,email,',
            'is_admin' => 'required|boolean',
            'enabled' => 'required|boolean',
        ]);
            // $prueba=(['name' => "hola"]);
            // dd($prueba);


        $user = new user;
        $user->name = stripslashes(htmlspecialchars($request->name));
        $user->email = stripslashes(htmlspecialchars($request->email));
        $user->is_admin = $request->is_admin;
        if($request->is_admin==="0")
        {
            $request->validate([
                'modulos_id_u' => 'required|integer',
            ]);
            $user->modulos_id_u = $request->modulos_id_u;

        }
        $user->enabled = $request->enabled;
        $user->password = User::generatePassword();
        $user -> save();






            // Mail::send('emails.email', $user, function($message)
            // {
            //     $message->to($user->email, $user->name)
            //             ->subject('sisUptag: Contraseña de acceso: '.$user->password);
            //     });

            // if (Mail::failures()) {


            //  }
            User::sendWelcomeEmail($user);









            if($request->is_admin==="0"){
                $usera = $user->modulos;
                $user -> nombre = $usera->nombre;
                return json_encode(['success' => true, 'user'=>$user, 'modulo'=>$usera]);
            }
            else{
                return json_encode(['success' => true, 'user'=>$user]);
            }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = user::find($id);

        return json_encode(['success' => true, 'user' => $user]);
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



        if($id==1)
        {
            return json_encode(['errorAdmin' => true]);
        }
        else{
            $user = user::find($id);
            $request->validate([
                'name' => 'required|regex:/^[a-zA-Z]+$/u|max:20',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'is_admin' => 'required|boolean',
                'enabled' => 'required|boolean',
            ]);
            if($request->is_admin==="0")
            {
                $request->validate([
                    'modulos_id_u' => 'required|integer',
                ]);
                $user->modulos_id_u = $request->modulos_id_u;
            }
            $user->name = stripslashes(htmlspecialchars($request->name));
            $user->email = stripslashes(htmlspecialchars($request->email));
            $user->is_admin = $request->is_admin;
            $user->enabled = $request->enabled;
            $user->save();
            $usera = $user->modulos;
            return json_encode(['success' => true, 'user'=>$user, 'modulo'=>$usera]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        // dd($user->documentos()->count());
        // if($user->documentos()->count()>0)
        // {
        //     return json_encode(['error' => true]);
        // }
        // else if($user->documentos()->count()==0)
        // {
            if($user->id==1)
            {
                return json_encode(['errorAdmin' => true]);
            }
            elseif($user->id==Auth::user()->id)
            {
                return json_encode(['sameUser' => true]);
            }
            else{
                $user->delete();
                return json_encode(['success' => true]);
            }

        // }
    }

    public function changePassword(Request $request)
    {


       /* $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails())
            {
                return json_encode(['error' => true, 'res' => 'Captcha invalida', "id" => "0"]);
            }
            else
            {*/

                if(!(Hash::check($request->current_password, Auth::user()->password)))
                    {
                        return json_encode(['error' => true, 'res' => 'La información introducida no coincide con la almacenada.', "id" => "1"]);
                    }
                 else if(strcmp($request->current_password, $request->password) == 0)
                    {
                        return json_encode(['error' => true, 'res' => 'Las claves deben ser diferentes. Por favor intente otra vez',"id" => "2"]);
                    }
                 else{
                        $validatedData = $request->validate([
                            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
                            'password_confirmation' => 'required|min:8|same:password',
                        ]);
                        $user = Auth::user();
                        $user->password = bcrypt($request->password);
                        $user->save();
                        return json_encode(['success' => true, 'res' => 'Actualizada satisfactoriamente']);
                    }
            //}




    }
}
