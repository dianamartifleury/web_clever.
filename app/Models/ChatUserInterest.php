<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUserInterest extends Model
{
    protected $fillable = ['session_id', 'interest'];
}
