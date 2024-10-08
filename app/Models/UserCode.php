<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCode extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function casts() : array
    {
        return [
            'expires_at' => 'date'
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(\App\Models\UserCode::class);
    }
}
