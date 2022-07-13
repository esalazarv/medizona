<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use HasFactory;


    /**
     * Query scopes
     */

    /**
     * To search customers by query string
     *
     * @param Builder $query
     * @param string|null $criteria
     * @return Builder
     */
    public function scopeSearch(Builder $query, string | null $criteria): Builder {
        return $query->where('name', 'like', "%{$criteria}%")
            ->orWhere('email', 'like', "%{$criteria}%");
    }
}
