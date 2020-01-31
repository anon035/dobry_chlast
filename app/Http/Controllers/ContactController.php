<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(Request $request)
    {
        $success = $request->query('success', -1);
        return view('contact', ['success' => $success]);
    }

    public function send(Request $request)
    {
        Mail::to(env('MAIL_USERNAME', 'obchod@dobry-chlast.sk'))
            ->send(new ContactMail($request->name, $request->surname, $request->email, $request->body));
        $success = 0;
        if (!Mail::failures()) {
            $success = 1;
        }
        return redirect()->route('contact.show', ['success' => $success]);
    }
}
