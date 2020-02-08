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
        $currentMonthDay = Carbon::today()->format('m-d');
        $birthdayUsers = User::whereRaw("DATE_FORMAT(birth_date, '%m-%d') = '{$currentMonthDay}'")->get();
        foreach($birthdayUsers as $user){
            DB::beginTransaction();
            $name = $user->name;
            $email = $user->email;
            $product = Product::where('id', 12)->first();
            $currentDate = Carbon::today()->format('Y-m-d');
            $purchase = Purchase::where('product_id', 12)->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '{$currentDate}'")->first();
            if (!$purchase) {
                $purchase = Purchase::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'n_classes' => $product->n_classes,
                    'expiration_days' => $product->expiration_days,
                    'status' => 0,
                ]);
            }
            app('App\Http\Controllers\MailSendingController')->birthdayEmail($email, $name);
            DB::commit();
        }
    }
}
