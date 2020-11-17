<?php

namespace App\Listeners;

use App\Models\Offter;
use Carbon\Carbon;

class UpdateStatusOffter
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
/*         $offter = Cache::remember('offters', $seconds, function () {
            return Offter::where('finish', '>=', now());
        }); */
        $now = Carbon::now();
        Offter::where([
            ['status', 1],
            ['finish', $now]
            ])
                ->update(['status' => 0]);
    }
}
