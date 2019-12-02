<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $form_id
 * @property integer $repondant_id
 * @property string $date_validation
 * @property string $created_at
 * @property string $updated_at
 * @property Formulaire $formulaire
 * @property Repondant $repondant
 * @property ReponsesRepondant[] $reponsesRepondants
 */
class FormRepondant extends Model
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
    protected $fillable = ['form_id', 'repondant_id', 'date_validation', 'created_at', 'updated_at'];

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
    public function repondant()
    {
        return $this->belongsTo('App\Repondant');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponsesRepondants()
    {
        return $this->hasMany('App\ReponsesRepondant', 'repondant_id');
    }
}
