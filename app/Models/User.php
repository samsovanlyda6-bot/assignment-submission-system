<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $user_id
 * @property int $role_id
 * @property string $full_name
 * @property string $email
 * @property string|null $phone
 * @property string $username
 * @property string $password
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Assignment> $createdAssignments
 * @property-read int|null $created_assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $createdCourses
 * @property-read int|null $created_courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Enrollment> $enrollments
 * @property-read int|null $enrollments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedbacks
 * @property-read int|null $feedbacks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $grades
 * @property-read int|null $grades_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Submission> $submissions
 * @property-read int|null $submissions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'full_name',
        'email',
        'phone',
        'username',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role && $this->role->role_name === 'admin';
    }

    // Check if user is teacher
    public function isTeacher()
    {
        return $this->role && $this->role->role_name === 'teacher';
    }

    // Check if user is student
    public function isStudent()
    {
        return $this->role && $this->role->role_name === 'student';
    }

    // Student enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'user_id');
    }

    // Student submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id', 'user_id');
    }

    // Courses created by this user (teacher/admin)
    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'created_by', 'user_id');
    }

    // Assignments created by this user (teacher/admin)
    public function createdAssignments()
    {
        return $this->hasMany(Assignment::class, 'created_by', 'user_id');
    }

    // Notifications for this user
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    // Grades received (for students)
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Submission::class, 'student_id', 'submission_id', 'user_id', 'submission_id');
    }

    // Feedback received (for students)
    public function feedbacks()
    {
        return $this->hasManyThrough(Feedback::class, Submission::class, 'student_id', 'submission_id', 'user_id', 'submission_id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'created_by', 'user_id');
    }

    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'created_by', 'user_id');
    }
}
