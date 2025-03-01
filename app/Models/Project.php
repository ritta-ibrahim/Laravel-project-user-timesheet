<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, BlamableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $columnNames = DB::getSchemaBuilder()->getColumnListing('projects');

        foreach ($filters as $key => $value) {
            if (in_array($key, $columnNames)) {
                if ($key == 'name') {
                    $query->where('value', 'LIKE', "%$value%");
                } else {
                    $query->Where($key, $value);
                }
            } else {
                $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                    $attribute = Attribute::where('name', $key)->first();

                    if ($attribute) {
                        switch ($attribute->type) {
                            case 'text':
                                $q->where('attribute_id', $attribute->id)
                                    ->where('value', 'LIKE', "%$value%");
                                break;

                            case 'number':
                                if (is_numeric($value)) {
                                    $q->where('attribute_id', $attribute->id)
                                        ->where('value', $value);
                                }
                                break;

                            case 'date':
                                if (strtotime($value)) {
                                    $q->where('attribute_id', $attribute->id)
                                        ->where('value', '=', $value);
                                }
                                break;

                            case 'select':
                                $q->where('attribute_id', $attribute->id)
                                    ->where('value', '=', $value);
                                break;
                        }
                    }
                });
            }
        }

        return $query;
    }
}
