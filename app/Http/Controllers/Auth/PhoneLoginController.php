<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class PhoneLoginController extends Controller
{
   /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        
        $data = $request->validate([
            'phone_number' => ['required', 'numeric'],
        ]);

        $user = User::where('phone_number',$data['phone_number'])->first();
        if($user===null) return redirect()->to('login')->withErrors(array('phone_number' => 'Phone Number invalid'));
                /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['phone_number'], "sms");
        return redirect()->route('phoneverify')->with(['phone_number' => $data['phone_number']]);
    }


}
