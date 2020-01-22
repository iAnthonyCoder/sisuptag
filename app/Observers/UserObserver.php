<?php

namespace App\Observers;

use App\modulo;
use App\bitacora;
use App\user;
use Auth;
class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "INSERTÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "USUARIOS";
        $bitacora->description = $user->name;
        $bitacora->save();
    }
    public function creating(User $user)
    {
        $user->name = strtoupper($user->name);
        $user->email = strtoupper($user->email);
    }   


    public function updating(User $user)
    {
        $user->name = strtoupper($user->name);
        $user->email = strtoupper($user->email);
    }   
    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        
        $bitacora = new bitacora;
        if(Auth::check())
        {
            $bitacora->user_id = Auth::user()->id;
        }
        else
        {
            $bitacora->user_id = $user->id;
        }
        $bitacora->actions = "EDITÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "USUARIOS";
        $bitacora->description = $user->name;

        $bitacora->save();
        
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "ELIMINÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "USUARIOS";
        $bitacora->description = $user->name;
        $bitacora->save();
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
