<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $feedback_id
 * @property int $submission_id
 * @property int $teacher_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Submission $submission
 * @property-read \App\Models\User $teacher
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereFeedbackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';
    
    protected $fillable = [
        'submission_id',
        'teacher_id',
        'comment'
    ];
    
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'submission_id');
    }
    
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'user_id');
    }
}