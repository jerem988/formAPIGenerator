<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Formulaire;
use App\Question;
use App\Reponse;
use App\ReponsesRepondant;
use App\FormRepondant;

class ReponsesRepondantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            //Supression des réponses existantes
            ReponsesRepondant::where('repondant_id', $data["repondant_id"])
                ->where('form_id', $data["form_id"])
                ->delete();

            //Ajout des nouvelles réponses
            foreach($data["reponse"] as $reponse){
                switch( $reponse["element"]){
                    case "textarea":
                        $reponse_repondant = new ReponsesRepondant();
                        $reponse_repondant->form_id = $data["form_id"];
                        $reponse_repondant->repondant_id = $data["repondant_id"];
                        $reponse_repondant->question_id = $reponse["question_id"];
                        $reponse_repondant->reponse_id = $reponse["inputs"][0]["id"];
                        $reponse_repondant->textarea = $reponse["reponse_textarea"];
                        $reponse_repondant->save();
                        break;
                    case "radiobox":
                        if($reponse["reponse_id_radio"] > 0) {
                            $reponse_repondant = new ReponsesRepondant();
                            $reponse_repondant->form_id = $data["form_id"];
                            $reponse_repondant->repondant_id = $data["repondant_id"];
                            $reponse_repondant->question_id = $reponse["question_id"];
                            $reponse_repondant->reponse_id = $reponse["reponse_id_radio"];
                            $reponse_repondant->save();
                        }
                        break;
                    case "checkbox":
                        foreach ($reponse["reponse_id_checkbox"] as $reponse_id){
                            $reponse_repondant = new ReponsesRepondant();
                            $reponse_repondant->form_id = $data["form_id"];
                            $reponse_repondant->repondant_id = $data["repondant_id"];
                            $reponse_repondant->question_id = $reponse["question_id"];
                            $reponse_repondant->reponse_id = $reponse_id;
                            $reponse_repondant->save();
                        }
                        break;
                    default:
                        break;

                }
            }

            //Clôturer le formulaire si formulaire valider par l'utilisateur
            if($data["cloture_form"] == true ){
                $this->clotureForm($data["id_form_repondant"]);
            }
        }catch (Exception  $e) {
            Log::error("Erreur lors de l'enregistrement des réponses du repondant N°".$data["repondant_id"]. "; ExceptionMessage: ".$e->getMessage());
            throw new Exception("Une erreur s'est produite.");
        }

        return "true";
    }

    public function clotureForm($id){
        try {
            $form_repondant = FormRepondant::find($id);
            $form_repondant->date_validation = Carbon::now()->toDateTimeString();
            $form_repondant->save();

        }catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur clôture du formulaire form_repondant id: ". $form_repondant['id']. " ExceptionMessage: ". $e->getMessage());
            return false;
        }

        return "true";
    }

    public function showByRepondant($form_id, $user_id)
    {
        $results = Formulaire::select('id','libelle')
            ->with(['questions' => function ($query) use ($user_id) {
                $query->select(['id', 'form_id','libelle','type'])
                    ->orderBy('id', 'asc')->with(['reponses' => function ($query) use ($user_id) {
                        $query->select(['id', 'form_id', 'question_id','libelle'])
                            ->orderBy('id', 'asc')->with(['reponsesRepondants' => function ($query) use ($user_id)  {
                                $query->select(['id', 'question_id', 'reponse_id','textarea'])
                                    ->where('repondant_id', $user_id)
                                    ->orderBy('id', 'asc');
                            }]);
                    }]);
            }])->with(['formRepondants' => function ($query) use ($user_id, $form_id)  {
                $query->select(['id', 'form_id', 'repondant_id','date_validation'])
                    ->where('repondant_id', $user_id)
                    ->where('form_id', $form_id)
                    ->first();
            }])
            ->where('formulaires.id', $form_id)
            ->first();

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
        //
    }
}
