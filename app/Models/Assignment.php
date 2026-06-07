<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $assignment_id
 * @property int $course_id
 * @property string $title
 * @property string|null $description
 * @property numeric $total_marks
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $due_date
 * @property bool $allow_late_submission
 * @property int $created_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Submission> $submissions
 * @property-read int|null $submissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereAllowLateSubmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereTotalMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Assignment extends Model
{
    protected $table = 'assignments';
    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'total_marks',
        'start_date',
        'due_date',
        'allow_late_submission',
        'created_by',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'allow_late_submission' => 'boolean',
        'total_marks' => 'decimal:2'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assignment_id', 'assignment_id');
    }
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Submission::class, 'assignment_id', 'submission_id');
    }
}
