<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Markdown;
use Mews\Purifier\Facades\Purifier;

class Paste extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'not_listed_id',
        'user_id',
        'type',
        'password'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markdown()
    {
        return Purifier::clean(Markdown::parse($this->content));
    }
}
