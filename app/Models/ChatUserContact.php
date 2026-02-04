<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUserContact extends Model
{
    protected $fillable = ['session_id', 'email', 'phone'];
}
