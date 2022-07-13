<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'date',
        'total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relations
     */

    public function items()
    {
        return $this->belongsToMany(Item::class, 'note_items')->withPivot('quantity', 'total');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

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
