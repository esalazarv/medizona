<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * To search notes by query string
     *
     * @param Builder $query
     * @param string $criteria
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $criteria): Builder {
        return $query->where('date', 'like', "%{$criteria}%")
            ->orWhere('total', 'like', "%{$criteria}%");
    }
}
