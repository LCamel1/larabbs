<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //用户的默认头像
        $avatars = [
            '/uploads/images/avatars/default/s5ehp11z6s.png',
            '/uploads/images/avatars/default/Lhd1SHqu86.png',
            '/uploads/images/avatars/default/LOnMrqbHJn.png',
            '/uploads/images/avatars/default/xAuDMxteQy.png',
            '/uploads/images/avatars/default/ZqM7iaP4CR.png',
            '/uploads/images/avatars/default/NDnzMutoxX.png',
        ];
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'introduction' => fake()->sentence(),
            'avatar' => fake()->randomElement($avatars),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
