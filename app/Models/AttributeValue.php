<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'value',
        'attribute_id',
        'project_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
