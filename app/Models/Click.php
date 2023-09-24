<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the lisings that owns the Click
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listings()
    {
        return $this->belongsTo(Listing::class);
    }
}
