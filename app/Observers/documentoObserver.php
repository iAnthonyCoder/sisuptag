<?php

namespace App\Observers;
use App\documento;
use App\bitacora;
use App\User;
use Auth;


class documentoObserver
{
    /**
     * Handle the documento "created" event.
     *
     * @param  \App\documento  $documento
     * @return void
     */
    public function created(documento $documento)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "INSERTÓ";
        $bitacora->model = "DOCUMENTOS";
        $bitacora->description = $documento->description;

        $author = $documento->user;
        $users = User::all();
        $modulo = $documento->modulo;
        //   foreach ($users as $user) {


        //         $user->notify(new NewDocument($documento,$author));


        //  }
        $bitacora->save();
    }

    /**
     * Handle the documento "updated" event.
     *
     * @param  \App\documento  $documento
     * @return void
     */
    public function updated(documento $documento)
    {
        if(Auth::user())
        {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "EDITÓ";
        $bitacora->model = "DOCUMENTOS";
        $bitacora->description = $documento->description;

        $author = $documento->user;
        $users = User::all();

        $bitacora->save();
        }
    }

    /**
     * Handle the documento "deleted" event.
     *
     * @param  \App\documento  $documento
     * @return void
     */
    public function deleted(documento $documento)
    {


        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "ELIMINÓ";
        $bitacora->model = "DOCUMENTOS";
        $bitacora->description = $documento->description;
        $bitacora->save();

    }

    /**
     * Handle the documento "restored" event.
     *
     * @param  \App\documento  $documento
     * @return void
     */
    public function restored(documento $documento)
    {
        //
    }

    /**
     * Handle the documento "force deleted" event.
     *
     * @param  \App\documento  $documento
     * @return void
     */
    public function forceDeleted(documento $documento)
    {
        //
    }
}
