<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";


    protected $fillable = ["codigo", "nombre", "descripcion", "precio", "url_imagen", "likes", "dislikes", "user_id"];

    protected $hidden = ["created_at", "updated_at"];

    //Relaciones
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
