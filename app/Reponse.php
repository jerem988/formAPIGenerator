<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $form_id
 * @property integer $question_id
 * @property string $libelle
 * @property string $created_at
 * @property string $updated_at
 * @property Formulaire $formulaire
 * @property Question $question
 * @property ReponsesRepondant[] $reponsesRepondants
 */
class Reponse extends Model
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
    protected $fillable = ['form_id', 'question_id', 'libelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulaire()
    {
        return $this->belongsTo('App\Formulaire', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponsesRepondants()
    {
        return $this->hasMany('App\ReponsesRepondant');
    }
}
