<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
						'email' => $this->faker->unique()->safeEmail,
						'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
						'remember_token' => Str::random(10),
						'tenant_id' => Tenant::factory()
        ];
    }
}
