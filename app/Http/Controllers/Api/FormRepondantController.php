<?php

namespace App\Http\Controllers\Api;

use App\FormRepondant;
use App\Repondant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FormRepondantController extends Controller
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
        //w
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

        try {
            $form_repondant = new FormRepondant();
            $form_repondant->form_id = $data['form_id'];
            $form_repondant->repondant_id = $data['repondant_id'];
            $form_repondant->save();
        }catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur lors de la modification du formulaire ".$e->getMessage());
            throw new Exception("Une erreur s'est produite.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = DB::table('form_repondants')
            ->leftJoin('repondants', 'form_repondants.repondant_id', '=', 'repondants.id')
            ->select(DB::raw('form_repondants.id as id_form_repondant, repondants.id, repondants.nom, repondants.mail,
            repondants.prenom ,  DATE_FORMAT(repondants.created_at, "%d/%m/%Y %H:%i") as created_at, 
            DATE_FORMAT(repondants.updated_at, "%d/%m/%Y %H:%i") as updated_at'))
            ->where('form_repondants.form_id', '=', $id)
            ->orderBy('repondants.id', 'desc')
            ->get();

        return $results->toJson();
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
        return FormRepondant::destroy($id);
    }

    public function getListOptionsRepondant($form_id){

        $results = DB::table('repondants as repondant')
            ->select(DB::raw('repondant.id, repondant.mail'))
            ->whereNotIn('repondant.id',function($query) use ($form_id) {
                $query->select('repondant_id')
                    ->from('form_repondants')
                    ->where('form_id', '=', $form_id)
                    ->get();
            })
            ->where('repondant.user_id',  Auth::id())
            ->orderBy('repondant.id', 'desc')
            ->get();
        return $results->toJson();
    }
}
