<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * Получить пользователя, создавшего пост.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить комментарии к посту.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }}
