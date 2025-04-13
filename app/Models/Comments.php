<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        // 'parent_id',
        // 'created_at',
        // 'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
