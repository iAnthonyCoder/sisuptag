<?php

namespace App\Observers;

use App\Restore;
use App\bitacora;
use Auth;

class restoreObserver
{
    /**
     * Handle the restore "created" event.
     *
     * @param  \App\Restore  $restore
     * @return void
     */
    public function created(Restore $restore)
    {
        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "CREÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "PUNTO DE RESTAURACIÓN";
        $bitacora->description = $restore->description;
        $bitacora->save();
    }

    /**
     * Handle the restore "updated" event.
     *
     * @param  \App\Restore  $restore
     * @return void
     */
    public function updated(Restore $restore)
    {
        //
    }

    /**
     * Handle the restore "deleted" event.
     *
     * @param  \App\Restore  $restore
     * @return void
     */
    public function deleted(Restore $restore)
    {
        //
    }

    /**
     * Handle the restore "restored" event.
     *
     * @param  \App\Restore  $restore
     * @return void
     */
    public function restored(Restore $restore)
    {
        //
    }

    /**
     * Handle the restore "force deleted" event.
     *
     * @param  \App\Restore  $restore
     * @return void
     */
    public function forceDeleted(Restore $restore)
    {
        //
    }
}
