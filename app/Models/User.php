<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'parent_id',
        'parent_email',
        'program',
        'grade',
        'birthdate',
        'teacher_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
    ];
    
    /**
     * Get the parent of a student.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    
    /**
     * Get the children (students) of a parent.
     */
    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Get the teacher of a student.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the students of a teacher.
     */
    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'teacher_id');
    }

    /**
     * Get the progress reports for a student.
     */
    public function progresses()
    {
        return $this->hasMany(Progress::class, 'student_id')->orderBy('date', 'desc');
    }

    /**
     * Get the most recent progress report for a student.
     */
    public function lastProgress(): HasOne
    {
        return $this->hasOne(Progress::class, 'student_id')->latest('date');
    }

    /**
     * Get the attendance records for a student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}
