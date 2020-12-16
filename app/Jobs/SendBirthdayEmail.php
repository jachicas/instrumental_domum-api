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

        return $data->each(function ($d) {
            Mail::to($d->email)->send(new BirthdayEmail);
        });
    }
}
