<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $report_id
 * @property string $report_type
 * @property \Illuminate\Support\Carbon $report_date
 * @property int $generated_by
 * @property string $file_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $generator
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereGeneratedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'report_id';
    
    protected $fillable = [
        'report_type',
        'report_date',
        'generated_by',
        'file_path',
        'parameters'
    ];
    
    protected $casts = [
        'report_date' => 'date'
    ];
    
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by', 'user_id');
    }
}