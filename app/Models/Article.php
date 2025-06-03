<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    protected $table = 'articles';

    protected $fillable = ['title', 'content', 'image'];

    /**
     * Buat relasi bahwa artikel ini dimiliki oleh satu user.
     */
    public function user($id)
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
