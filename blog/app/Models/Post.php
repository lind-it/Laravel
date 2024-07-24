<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'description', 'autor_name'];

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'name', 'autor_name');
    }

    public function getLikesCount()
    {
        $likes = $this->like()->where([
                                'post_id' => $this->id,
                                'like'=> true
                                ])
                                ->get()
                                ->count();

        $dislikes = $this->like()->where([
                                'post_id' => $this->id,
                                'like'=> false
                                ])
                                ->get()
                                ->count();

        return $likes - $dislikes;
    }
}
