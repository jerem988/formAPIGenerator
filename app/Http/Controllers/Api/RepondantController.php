<?php

namespace App\Http\Controllers\Api;

use App\Repondant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RepondantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = DB::table('repondants as repondant')
            ->select(DB::raw('repondant.id, repondant.nom, repondant.mail,
            repondant.prenom ,  DATE_FORMAT(repondant.created_at, "%d/%m/%Y %H:%i") as created_at, 
            DATE_FORMAT(repondant.updated_at, "%d/%m/%Y %H:%i") as updated_at'))
            ->where('repondant.user_id',  Auth::id())
            ->orderBy('repondant.id', 'desc')
            ->get();

        return $results->toJson();
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
        $repondant = new Repondant();
        $repondant->nom = $data['nom'];
        $repondant->prenom = $data['prenom'];
        $repondant->mail = $data['mail'];
        $repondant->user_id = Auth::id();
        $repondant->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Repondant::destroy($id);
    }
}
