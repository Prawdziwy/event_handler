<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'name',
        'start_date',
        'end_date',
    ];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
