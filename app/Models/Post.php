<?php

namespace App\Models;

use App\Models\Comments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
 //El fillable es la información que se va a llenar en la base de datos, laravel lee esto 
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];
//Los postst perteneces a un usuario y cuando se recupera el usuario se recuperan solo los campos name y username para optimizar la llamada a la base de datos
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->orderBy('created_at', 'desc');
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
