<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Formulaire;
use App\Question;
use App\Reponse;
use Illuminate\Support\Facades\Auth;

class FormulaireBuilderController extends Controller
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
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
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
        //dd($data);
        try {
            DB::beginTransaction();
                $this->addOrUpdateData($request->json()->all());
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur lors de la création du formulaire ".$e->getMessage());
            DB::rollBack();
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
        $results = Formulaire::select('id','libelle')
            ->with(['questions' => function ($query) {
                $query->select(['id', 'form_id','libelle','type'])
                    ->orderBy('id', 'asc')->with(['reponses' => function ($query) {
                        $query->select(['id', 'form_id', 'question_id','libelle'])
                            ->orderBy('id', 'asc');
                    }]);
            }])
            ->where('formulaires.id', $id)
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
    public function update($id, Request $request)
    {
        //dd($data);
        try {
            //transactions
            DB::beginTransaction();
            $this->addOrUpdateData($request->json()->all(), $id);
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            Log::error("Erreur lors de la modification du formulaire ".$e->getMessage());
            DB::rollBack();
            throw new Exception("Une erreur s'est produite.");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formulaire $formulaire)
    {
        $formulaire->delete();
    }

    public function addOrUpdateData($data = array(), $id = 0){
        $user = Auth::user();

        //Création
        if($id == 0) {
            $formulaire = new Formulaire();
            $formulaire->libelle = $data['libelle'];
            $formulaire->user_id = Auth::id();
            $formulaire->save();
        //modification
        }else{
            $formulaire = Formulaire::find($id);
            $formulaire->libelle = $data['libelle'];
            $formulaire->save();
            //Supression des questions et réponses du formulaire (CASCADE)
            Question::where('form_id', $id)->delete();
        }

        //Ajout des questions
        foreach ($data['questions'] as $data_question){
            $question = new Question();
            $question->libelle = $data_question['label'];
            $question->form_id = $formulaire->id;
            $question->type = $data_question['element'];
            $question->save();

            foreach ($data_question['inputs'] as $input){
                $reponse = new Reponse();
                $reponse->libelle = $input['value'];
                $reponse->form_id = $formulaire->id;
                $reponse->question_id = $question->id;
                $reponse->save();
            }

        }
    }
}
