<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $file_id
 * @property int $assignment_id
 * @property string $file_name
 * @property string $file_path
 * @property \Illuminate\Support\Carbon $uploaded_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Assignment $assignment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AssignmentFile whereUploadedAt($value)
 * @mixin \Eloquent
 */
class AssignmentFile extends Model
{
    protected $table = 'assignment_files';
    protected $primaryKey = 'file_id';
    
    protected $fillable = [
        'assignment_id',
        'file_name',
        'file_path',
        'uploaded_at'
    ];
    
    protected $casts = [
        'uploaded_at' => 'datetime'
    ];
    
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'assignment_id');
    }
}