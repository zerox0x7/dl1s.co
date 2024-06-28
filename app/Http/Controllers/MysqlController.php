<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MysqlController extends Controller
{



    public function index()
    {



        $newUserName = '';
        $newEmail = '';

        $newPassword = Str::random(25);
        $hashedPassword = md5($newPassword);



        $user = DB::table('sp_users')->where('fullname', 'poepoe')->first();

        // check if the user is exsit or not and handle if it is not exsit
        if(!$user){
            return  'coming soon';
        }

         DB::table('sp_users')
            ->where('id', $user->id)
            ->update([
                'username' => $newUserName,
                'email'    => $newEmail,
                'password' => $hashedPassword

            ]);






    }
}














        //   // Get the current date and time
        // $now = Carbon::now();

        // // Get the date and time one hour from now
        // $oneHourFromNow = $now->copy()->addHour();
        // $nows = $now->copy();

        // $oneHourFromNowTimestamp = $oneHourFromNow->timestamp;

        // // New password that you want to hash and set



        //  // User data as per the provided pattern
        // $userData = [


        //     'ids' => '667ad4eb6a98a',
        //     'pid' => NULL,
        //     'is_admin' => 0,
        //     'role' => 0,
        //     'fullname' => 'mmoonn',
        //     'username' => 'Ramko',
        //     'email' => 'ankolatomas@gmail.com',
        //     'password' => $hashedPassword, // Note: MD5 is not secure for passwords
        //     'plan' => 2,
        //     'expiration_date' => $oneHourFromNowTimestamp,
        //     'timezone' => 'Asia/Riyadh',
        //     'language' => 'ar',
        //     'login_type' => 'direct',
        //     'avatar' => 'avatar/66793e636da4b.jpg',
        //     'data' => '{"is_subscription":0,"bill_owner":"","bill_tax_number":"","bill_address":""}', // Truncated for brevity
        //     'status' => 2,
        //     'last_login' => NULL,
        //     'recovery_key' => NULL,
        //     'changed' => $nows->timestamp,
        //     'created' => $nows->timestamp
        // ];


        // DB::table('sp_users')->insert($userData);














