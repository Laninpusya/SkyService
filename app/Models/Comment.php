<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];

    /**
     * Получить пользователя, написавшего комментарий.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить пост, к которому относится комментарий.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }}
