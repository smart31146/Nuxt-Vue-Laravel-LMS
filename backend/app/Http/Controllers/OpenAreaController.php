<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Validator;
use Log;

class OpenAreaController extends Controller
{

    /**
     * 問い合わせの送信
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'your_name' => 'required',
            'your_email' => 'required|email',
            'your_body' => 'required',
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $in_array = array (
            'your_name' => $request->your_name,
            'your_email' => $request->your_email,
            'your_body' => $request->your_body,
        );

        Mail::send(['text' => 'contact-admin'], $in_array, function($message) use($in_array)
        {

            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->to(env('MAIL_TO_ADDRESS'))->subject(config('subject.MAIL_CONTACT_SUBJECT'));

        });

        return response()->json(['success' => true], 200);

    }

}
