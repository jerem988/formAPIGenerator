<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $libelle
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property FormRepondant[] $formRepondants
 * @property Question[] $questions
 * @property Reponse[] $reponses
 * @property ReponsesRepondant[] $reponsesRepondants
 */
class Formulaire extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'libelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formRepondants()
    {
        return $this->hasMany('App\FormRepondant', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Question', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponses()
    {
        return $this->hasMany('App\Reponse', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponsesRepondants()
    {
        return $this->hasMany('App\ReponsesRepondant', 'form_id');
    }
}
