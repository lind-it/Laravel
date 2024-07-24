<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    //делаем эти поля заполняемыми при масовом присвоении
    protected $fillable = ['name', 'email', 'password', 'token'];

    public function post()
    {
        return $this->hasMany(Post::class, 'autor_name', 'name');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_name', 'name');
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
