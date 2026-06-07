<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $submission_file_id
 * @property int $submission_id
 * @property string $file_name
 * @property string $file_path
 * @property \Illuminate\Support\Carbon $uploaded_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Submission $submission
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereSubmissionFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubmissionFile whereUploadedAt($value)
 * @mixin \Eloquent
 */
class SubmissionFile extends Model
{
    protected $table = 'submission_files';
    protected $primaryKey = 'submission_file_id';
    
    protected $fillable = [
        'submission_id',
        'file_name',
        'file_path',
        'uploaded_at'
    ];
    
    protected $casts = [
        'uploaded_at' => 'datetime'
    ];
    
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'submission_id');
    }
}