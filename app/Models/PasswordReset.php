<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PasswordReset extends Model
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'password_reset_tokens';
    public $timestamps = false; 
    protected $fillable = ['email', 'token', 'created_at'];

}
