<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Back Office */
Auth::routes();

Route::get('/', function () {
    return view('myform');
})->name('welcome')->middleware('auth');

Route::get('mes-formulaire', function () {
    return view('myform');
})->name('my-form')->middleware('auth');

Route::get('creer-un-formulaire', function () {
    return view('main');
})->name('form-creation')->middleware('auth');

Route::get('editer-un-formulaire/{id}', function ($id) {
    return view('edit', ['id' => $id]);
})->name('form-edition')->middleware('auth');

Route::get('mes-repondants', function () {
    return view('myrepondant');
})->name('my-repondant')->middleware('auth');

Route::get('mes-repondants-formulaires/{id}', function ($id) {
    return view('repondantform', ['id' => $id]);
})->name('my-repondant-formulaire')->middleware('auth');

/* Front Office */
Route::get('enquete-de-satisafication/{id_form_repondant}/{form_id}/{user_id}', function ($id_form_repondant, $form_id, $user_id) {
    return view('repondantview', ['id_form_repondant' => $id_form_repondant, 'form_id' => $form_id, 'user_id' => $user_id]);
})->name('repondant-view');
