<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function injectModalScript(Request $request)
    {
        // return response()->view('inject-modal-js')->header('Content-Type', 'application/javascript');

        return view('inject-modal-js');
    }
}
