<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Rfc4122\UuidV1;
use Illuminate\Support\Str;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'title' => Str::random(10),
            'done' => random_int(0, 1),
            'created_at' => now('utc'),
            'updated_at' => now('utc'),
        ];
    }
}
