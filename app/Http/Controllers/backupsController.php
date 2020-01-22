<?php

namespace App\Http\Controllers;
use Artisan;
use Backup;
use App\Backups;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Storage;



class backupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backups");
    }

    private function findDBs(string $string)
    {
        $db_list = str_replace(array('|','-','+', " ", "\"",""," ","NameCreatedatSize\r\n","\r","\""), '', $string);
        dd($db_list);
        preg_match_all("/\ ?([A-Za-z]+)+-([0-9\-\_]+)\.sql/", $string, $matches);
        
        return $matches;
    }

    public function indexGet()
    {
       /* $output = new BufferedOutput;
        Artisan::call("snapshot:list", array(), $output);
        $db_list = $output->fetch();

        $matches = $this->findDBs($db_list);
        dd($matches);
        $matches_name = $matches[1];
        $matches_created_at = $matches[2];

        $response = array();
        foreach ($matches_name as $key => $value) {
        $response[$key] = ['id' => $key, 'name' => $matches_name[$key], 'created_at' => $matches_created_at[$key]];
        }
        
        return json_encode($response);*/

        $disk = Storage::disk('backups');
        
        $files = $disk->files(config('laravel-backup.backup.name'));
        
        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.sql' && $disk->exists($f)) {

                $backups[] = [
                    
                    'file_path' => $f,
                    'file_name' => str_replace(config('laravel-backup.backup.name') . '/', '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
                
            }
            
        }
        dd($backups);
        // reverse the backups, so the newest one would be on top
       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name = "asd")
    {
        // $backup_datetime = date('Y-m-d_H-i-s');
        // $backup_name = "{$name}-{$backup_datetime}.sql";
        // try {
        //   Artisan::call("snapshot:create", ["name"=>$backup_name]);
        // } catch (exception $e) {
        //   return false;
        // }

        // $matches = $this->findDBs($backup_name);
        // $matches_name = $matches[1];
        // $matches_created_at = $matches[2];

        // $backup = array('id' => 9999999999, 'name' => $matches_name[0], 'created_at' => $matches_created_at[0]);

        // return $backup;
        $token=str_random(24);
        $token=$token.time();
        Backup::export($token);
        // dd(Backup::getProcessOutput());
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
     * @param  \App\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function show(backup $backup)
    {
       
        // ini_set('memory_limit','1024M');
    
            
        //     try {
        //       Artisan::call("snapshot:load", ["asd-2019-06-14_20-09-37.sql.sql"]);
        //       return json_encode(['success' => true]);
        //     } catch (exception $e) {
        //       return json_encode(['success' => false]);
        //     }
        
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function edit(backup $backup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, backup $backup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\backup  $backup
     * @return \Illuminate\Http\Response
     */
    public function destroy(backup $backup)
    {
        //
    }
}
