<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function() {
    //Back
    Route::apiResource('formulaireBuilders', 'FormulaireBuilderController');
    Route::apiResource('formulaires', 'FormulaireController');
    Route::apiResource('repondants', 'RepondantController');
    Route::apiResource('repondants-forms', 'FormRepondantController');
    Route::apiResource('mails', 'MailController');
    Route::apiResource('reponses-repondant', 'ReponsesRepondantController');

    Route::get('/repondants-forms/lister-formulaire-options-repondant/{form_id}', 'FormRepondantController@getListOptionsRepondant')
        ->name('get-list-options-repondant');

    //Front
    Route::get('/reponses-repondant/lister-formulaire-par-repondant/{form_id}/{user_id}', 'ReponsesRepondantController@showByRepondant')
        ->name('show-form-by-repondant');
});
