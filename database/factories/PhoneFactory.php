<?php

namespace Database\Factories;

use App\Models\Phone;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            	'tenant_id' => Tenant::factory()
        ];
    }
}
