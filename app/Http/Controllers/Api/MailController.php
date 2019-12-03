<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RepondantMail;


class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();
        if($this->sendMail($data)){
            return "true";
        }

        return "false";

        //return (new App\RepondantMail($data))->render();
    }

    public function sendMail($data){
        try {

            Mail::send(new RepondantMail($data));
        }catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur lors de l'envoi du mail au répondant: ". $data['mail']. $e->getMessage());
            throw new Exception("Une erreur s'est produite.");
        }

        return true;
    }
}
