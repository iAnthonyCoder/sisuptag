<?php

namespace App\Listeners;

use App\bitacora;
use App\Events\RestoreEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class Restored
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RestoreEvent  $event
     * @return void
     */
    public function handle(RestoreEvent $event)
    {

        $bitacora = new bitacora;
        $bitacora->user_id = Auth::user()->id;
        $bitacora->actions = "RESTAURÓ";
        $bitacora->actions = strtoupper($bitacora->actions);
        $bitacora->model = "SISTEMA";
        $bitacora->description = $event->restore->description;
        $bitacora->save();
    }
}
