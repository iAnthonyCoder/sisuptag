<?php

namespace App\Http\Controllers;
use Backup;
use App\Restore;
use Illuminate\Http\Request;
use Storage;
use Auth;
use App\Events\RestoreEvent;

class restoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("restores");
    }




    public function indexGet()
    {

        $disk = Storage::disk('backups');
        $files = $disk->files(config('laravel-backup.backup.name'));
        $backups = [];

                $restore=Restore::all();
                foreach($restore as $file)
                {
                    foreach ($files as $k => $f) {
                        // only take the zip files into account
                        if (substr($f, -4) == '.sql' && $disk->exists($f)) {
                            if($token=substr($f,0,-4)==$file->token);
                            {
                                $file["file_path"]=$f;
                                $file["file_name"]=$f;
                                $file["size"]=$disk->size($f);
                                $file["last_modified"]= $disk->lastModified($f);
                            }
                        }
                    }
                }

        //;
        return json_encode(['success' => true, 'restores'=>$restore]);
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
        $disk = Storage::disk('backups');

        $token=str_random(24);
        $token=$token.time();
        Backup::export($token);
        $restore= new Restore;
        $restore->token=$token;
        $restore->description=$request->description;
        $restore->size=$disk->size($token.".sql");

        $restore -> save();
        return json_encode(['success' => true, 'restore'=>$restore]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restore  $restore
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restore = Restore::select("id","description")->find($id);

        return json_encode(['success' => true, 'restore' => $restore]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restore  $restore
     * @return \Illuminate\Http\Response
     */
    public function edit(Restore $restore)
    {

        $restore = Restore::find($restore->id);
        $token = $restore->token;
        $path=(storage_path().'/backup');




        if(Backup::restore($path.'/'.$token.'.sql'))
        {
            event(new RestoreEvent($restore));
            Auth::logout();
            return redirect()->to('/login')->with('success', 'Base de datos restaurada');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restore  $restore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restore = restore::find($id);

        $restore->description = $request->description;
        $restore->save();
        return json_encode(['success' => true, 'restore'=>$restore]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restore  $restore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restore $restore)
    {
        $restore->token;

            if(file_exists(storage_path().'\backup\\'.$restore->token.".sql") AND !empty($restore->token))
            {
                unlink(storage_path().'\backup\\'.$restore->token.".sql");
            }
            $restore->delete();
            return json_encode(['success' => true]);

    }
}
