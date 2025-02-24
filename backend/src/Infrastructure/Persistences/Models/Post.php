<?php

namespace Src\Infrastructure\Persistences\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Shared\Database\Factories\PostFactory;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use SoftDeletes, HasFactory;

    protected static function newFactory(): PostFactory|Factory
    {
        return PostFactory::new();
    }

    protected $fillable = ['title', 'summary', 'content', 'status_id', 'user_id'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
