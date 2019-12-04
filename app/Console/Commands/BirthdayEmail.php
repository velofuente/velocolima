<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\{User,Purchase,Product};
use Carbon\Carbon;
use DB, Log;

class BirthdayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:birthdayEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email with info of a free class promotion';

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
        /*$user = User::where('email','pjimenez0@ucol.mx');
        $name = $user->name;
        $email = $user->email;*/
        $birthdayUsers = User::where('birth_date','like', '%'.Carbon::today()->format('m-d').'%')->get();
        foreach($birthdayUsers as $user){
            DB::beginTransaction();
            $name = $user->name;
            $email = $user->email;
            // ID del producto "Cumpleaños" en Pruebas  es id = 11, en Prod. es id = 12
            $product = Product::where('id', 12)->first();
            $purchase = Purchase::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
                'status' => 0,
            ]);
            app('App\Http\Controllers\MailSendingController')->birthdayEmail($email, $name);
            DB::commit();
        }
    }
}
