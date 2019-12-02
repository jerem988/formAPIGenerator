<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $form_id
 * @property string $libelle
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 * @property Formulaire $formulaire
 * @property Reponse[] $reponses
 * @property ReponsesRepondant[] $reponsesRepondants
 */
class Question extends Model
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
    protected $fillable = ['form_id', 'libelle', 'type', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulaire()
    {
        return $this->belongsTo('App\Formulaire', 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponses()
    {
        return $this->hasMany('App\Reponse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponsesRepondants()
    {
        return $this->hasMany('App\ReponsesRepondant');
    }
}
