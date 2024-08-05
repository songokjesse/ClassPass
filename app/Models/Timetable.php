<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['course_id', 'location_name', 'date', 'start_time', 'end_time'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
