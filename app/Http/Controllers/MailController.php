<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){
        return view('home.contact');
    }
    public function sendEmail(Request $request){
        $data=['from'=>'jovanmilanovic999@gmail.com','sender'=>$request->email,'name'=>$request->name,'body'=>$request->body];
        Mail::send('email.content',['data'=>$data],function($message) use ($data){
            $message->from($data['from'])->to($data['sender'])->subject('Contact us');
        });
        return redirect('home')->with('Success');

    }
}
