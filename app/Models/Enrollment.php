<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $enrollment_id
 * @property int $course_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon $enrolled_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereEnrolledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereEnrollmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enrollment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Enrollment extends Model
{
    protected $primaryKey = 'enrollment_id';
    
    protected $fillable = [
        'course_id',
        'student_id',
        'enrolled_at'
    ];
    
    protected $casts = [
        'enrolled_at' => 'datetime',
    ];
    
    // Add this to automatically set enrolled_at when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->enrolled_at)) {
                $model->enrolled_at = now();
            }
        });
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'user_id');
    }
}