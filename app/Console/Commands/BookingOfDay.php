<?php

namespace App\Console\Commands;
use App\Http\Controllers\BookingController;
use Illuminate\Console\Command;

class BookingOfDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // app()->call('App\Http\Controllers\BookingController@exporttext');
        // \App::call('BookingController@exporttext');
        // (new BookingController)->method('exporttext');
        app()->call('App\Http\Controllers\BookingController@exporttext');
        \Log::info("Cron is working fine!");

        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        $this->info('Cron Cummand Run successfully!');

    }
}
