<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            $query->where($key, 'LIKE', "%$value%");
        }
        return $query;
    }
}
