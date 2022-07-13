<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * To search items by query string
     *
     * @param Builder $query
     * @param string $criteria
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $criteria): Builder {
        return $query->where('name', 'like', "%{$criteria}%")
            ->orWhere('sku', 'like', "%{$criteria}%")
            ->orWhere('price', 'like', "%{$criteria}%");
    }
}
