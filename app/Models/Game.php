<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_id',
        'loser_id',
    ];

    const UPDATED_AT = null;

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function loser()
    {
        return $this->belongsTo(User::class, 'loser_id');
    }
}
