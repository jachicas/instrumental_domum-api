<?php

namespace App\Jobs;

use App\Mail\BirthdayEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Mail\EmailForQueue;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void`
     */
    public function handle()
    {
        $now = Carbon::now();
        $day = $now->isoFormat("D");
        $month = $now->isoFormat("M");
        $data = Employee::whereDay('birthdate', $day)
            ->whereMonth('birthdate', $month)
            ->get();

        if ($data->isEmpty()) {
            return response('No hay cumpleanero', 404);
        }

        return $data->each(function ($d) {
            Mail::to($d->email)->send(new BirthdayEmail);
        });
    }
}
