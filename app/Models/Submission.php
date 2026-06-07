<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $submission_id
 * @property int $assignment_id
 * @property int $student_id
 * @property string|null $submission_text
 * @property string|null $file_path
 * @property \Illuminate\Support\Carbon $submitted_at
 * @property bool $is_late
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Assignment $assignment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedbacks
 * @property-read int|null $feedbacks_count
 * @property-read \App\Models\Grade|null $grade
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereIsLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereSubmissionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Submission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Submission extends Model
{
    protected $table = 'submissions';
    protected $primaryKey = 'submission_id';
    
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_text',
        'file_path',
        'submitted_at',
        'is_late',
        'status'
    ];
    
    protected $casts = [
        'submitted_at' => 'datetime',
        'is_late' => 'boolean'
    ];
    
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'assignment_id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }
    
    public function grade()
    {
        return $this->hasOne(Grade::class, 'submission_id', 'submission_id');
    }
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'submission_id', 'submission_id');
    }
}