<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate;
use Illuminate\Support\Str;
use App\User;
use App\FormRepondant;
use App\Formulaire;
use App\Question;
use App\Repondant;
use App\Reponse;
use App\ReponsesRepondant;

class FormDeleteCascadeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFormDeleteCascade()
    {
        //Création d'un utilisateur fictif
        $user = factory('App\User')->create();

        //Création d'un formulaire fictif
        $formulaire = factory('App\Formulaire')->create([
            'user_id' => $user->id
        ]);

        //Création d'une question fictive
        $question = factory('App\Question')->create([
            'form_id' => $formulaire->id
        ]);

        //Création d'une reponse fictive
        $reponse = factory('App\Reponse')->create([
            'form_id' => $formulaire->id,
            'question_id' => $question->id
        ]);

        //Création répondant fictif
        $repondant = factory('App\Repondant')->create([
            'user_id' => $user->id
        ]);

        $form_repondant = factory('App\FormRepondant')->create([
            'form_id' => $formulaire->id,
            'repondant_id' => $repondant->id
        ]);

        $reponses_repondant = factory('App\ReponsesRepondant')->create([
            'form_id' => $formulaire->id,
            'question_id' => $question->id,
            'reponse_id'=>$reponse->id,
            'repondant_id'=>$repondant->id,
        ]);

        // Suppression du formulaire
        Formulaire::where('id',$formulaire->id)->delete();

        //Test delete en cascade
        $this->assertEquals(Question::find($question->id), null);
        $this->assertEquals(Reponse::find($reponse->id), null);
        $this->assertEquals(FormRepondant::find($form_repondant->id), null);
        $this->assertEquals(ReponsesRepondant::find($reponses_repondant->id), null);
    }
}
