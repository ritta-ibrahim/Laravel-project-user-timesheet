<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory, BlamableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'task_name',
        'hours',
        'user_id',
        'project_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($key == 'task_name') {
                $query->where($key, 'LIKE', "%$value%");
            } else {
                $query->where($key, $value);
            }
        }
        return $query;
    }
}
