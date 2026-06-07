<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $history_id
 * @property int $submission_id
 * @property string $action
 * @property int $performed_by
 * @property \Illuminate\Support\Carbon $performed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $performer
 * @property-read \App\Models\Submission $submission
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory whereHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory wherePerformedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubmissionHistory extends Model
{
    protected $table = 'submission_history';
    protected $primaryKey = 'history_id';
    
    protected $fillable = [
        'submission_id',
        'action',
        'performed_by',
        'performed_at',
        'details'
    ];
    
    protected $casts = [
        'performed_at' => 'datetime'
    ];
    
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'submission_id');
    }
    
    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by', 'user_id');
    }
}