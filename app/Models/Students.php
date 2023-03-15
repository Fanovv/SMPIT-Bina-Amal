<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Students extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = "students";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        'nama', 'nis', 'class_id',
    ];
}
