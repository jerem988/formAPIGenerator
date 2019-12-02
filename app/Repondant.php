<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $nom
 * @property string $prenom
 * @property string $mail
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property FormRepondant[] $formRepondants
 * @property ReponsesRepondant[] $reponsesRepondants
 */
class Repondant extends Model
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
    protected $fillable = ['user_id', 'nom', 'prenom', 'mail', 'created_at', 'updated_at'];

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
        return $this->hasMany('App\FormRepondant');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponsesRepondants()
    {
        return $this->hasMany('App\ReponsesRepondant');
    }
}
