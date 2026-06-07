<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $course_id
 * @property string $course_name
 * @property string $course_code
 * @property string|null $description
 * @property int $created_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Assignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Enrollment> $enrollments
 * @property-read int|null $enrollments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_name',
        'course_code',
        'description',
        'created_by',
        'status'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'course_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id', 'course_id', 'user_id')
                    ->withPivot('enrolled_at', 'status', 'progress')
                    ->withTimestamps();
    }

}
