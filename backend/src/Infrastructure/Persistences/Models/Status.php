<?php

namespace Src\Infrastructure\Persistences\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
