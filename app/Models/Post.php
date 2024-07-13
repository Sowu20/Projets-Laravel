<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $table = 'posts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'titre',
        'contenu',
        'user_id'
    ];

    /**
        The attributes that should be casted to native types.*
        @var array
    */
    protected $casts = [
        'id' => 'integer',
        'titre' => 'string',
        'contenu' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

}
