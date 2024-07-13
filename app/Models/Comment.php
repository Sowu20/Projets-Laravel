<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   
     
    use HasFactory;

    public $table = 'posts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'nom',
        'titre',
        'contenu',
        'id_post',
        'id_user'

    ];

protected $casts = ['id' => 'integer','nom' => 'string','titre' => 'string','contenu' => 'text','id_post' =>'foreign_key', 'id_user' => 'foreign_key'];
}

