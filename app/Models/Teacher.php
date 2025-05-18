<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'position',
        'specialization',
        'bio',
        'photo',
        'email',
        'phone',
        'is_popular',
        'sort_order',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the classes taught by the teacher.
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    /**
     * Get the students taught by the teacher.
     */
    public function students()
    {
        return $this->hasMany(User::class, 'teacher_id');
    }

    /**
     * Get the progress reports written by the teacher.
     */
    public function progressReports()
    {
        return $this->hasMany(Progress::class, 'teacher_id');
    }
}
