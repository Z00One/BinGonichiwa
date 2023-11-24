<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $winnerId = User::inRandomOrder()->first()->id;
        $loserId = User::inRandomOrder()->where('id', '!=', $winnerId)->first()->id;
        return [
            'winner_id' => $winnerId,
            'loser_id' => $loserId,
            'created_at' => now(),
        ];
    }
}
