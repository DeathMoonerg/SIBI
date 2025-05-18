<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'progresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'teacher_id',
        'date',
        'start_time',
        'end_time',
        'material_covered',
        'achievements',
        'challenges',
        'score',
        'overall_score',
        'notes',
        'parent_comment',
        'parent_comment_at',
        'teacher_reply',
        'teacher_reply_at',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_status',
        'verification_note'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'score' => 'integer',
        'overall_score' => 'integer',
        'parent_comment_at' => 'datetime',
        'teacher_reply_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Get the student that owns the progress report.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher that wrote the progress report.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the verifier of the progress report.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
} 
 
 