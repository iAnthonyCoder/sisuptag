<?php

namespace App\Observers;
use App\modulo;
use App\bitacora;
use App\user;
use Auth;
class moduloObserver
{
    /**
     * Handle the modulo "created" event.
     *
     * @param  \App\modulo  $modulo
     * @return void
     */

    public function creating(modulo $modulo)
    {
        $modulo->nombre = strtoupper($modulo->nombre);
        $modulo->descripcion = strtoupper($modulo->descripcion);
    }


    public function updating(modulo $modulo)
    {
        $modulo->nombre = strtoupper($modulo->nombre);
        $modulo->descripcion = strtoupper($modulo->descripcion);
        /*if($user->isDirty('email')){
        // email has changed
        $new_email = $user->email;
        $old_email = $user->getOriginal('email');
      }
    }*/
    }

    public function created(modulo $modulo)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "INSERTÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "MODULOS";
        $bitacora->description = $modulo->nombre;
        $bitacora->save();
    }

    /**
     * Handle the modulo "updated" event.
     *
     * @param  \App\modulo  $modulo
     * @return void
     */
    public function updated(modulo $modulo)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "EDITÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "MODULOS";
        $bitacora->description = $modulo->nombre;
        $users = User::all();


        // foreach ($users as $user) {
        //     $user->notify(new NewDocument($modulo, Auth::user()));
        // }


        $bitacora->save();
    }

    /**
     * Handle the modulo "deleted" event.
     *
     * @param  \App\modulo  $modulo
     * @return void
     */
    public function deleted(modulo $modulo)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "ELIMINÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "MODULOS";
        $bitacora->description = $modulo->nombre;
        $bitacora->save();
    }

    /**
     * Handle the modulo "restored" event.
     *
     * @param  \App\modulo  $modulo
     * @return void
     */
    public function restored(modulo $modulo)
    {
        //
    }

    /**
     * Handle the modulo "force deleted" event.
     *
     * @param  \App\modulo  $modulo
     * @return void
     */
    public function forceDeleted(modulo $modulo)
    {
        //
    }
}
