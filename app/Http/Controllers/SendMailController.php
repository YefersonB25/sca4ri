<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index()
    {
        Mail::to('zabaletacastellar@gmail.com')->send(new NotifyMail());

        if(Mail::failures())
        {
            return response()->json(array('msg' => 'Sorry! Please try again latter'), 200);
        }
        else
        {
            return response()->json(array('msg' => 'Great! Successfully send in your mail'), 200);
        }
    }
}
