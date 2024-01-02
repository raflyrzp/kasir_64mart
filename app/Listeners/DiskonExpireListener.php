<?php

namespace App\Listeners;

use App\Models\Diskon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DiskonExpireListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Diskon::where('tanggal_berakhir', '<=', now())->delete();
    }
}
