<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index(Request $request)
    {

            // logger($request->all());

            // $user = DB::table('users')->where('id', 1)->first();

            return response()->json(['message' => 'Event processed successfully'], 200);



    }
}
