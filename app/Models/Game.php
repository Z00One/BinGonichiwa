<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'winner_id',
        'loser_id',
    ];

    public function records()
    {
        return $this->hasOne(Record::class);
    }
}
