<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Attendance extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "attendances";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'student_id', 'class_id', 'date', 'subuh', 'zuhur', 'ashar', 'maghrib', 'isya'
    ];
}
