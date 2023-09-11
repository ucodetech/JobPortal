<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        // returns a string from our table that we want to use to bind our url
        return 'slug';
    }
    /**
     * Get all of the clicks for the Listing
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Get the user that owns the Listing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tags that belong to the Listing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    
}
