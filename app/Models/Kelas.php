<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kelas extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "classes";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'class_name', 'class_id', 'wali_id',
    ];
}
