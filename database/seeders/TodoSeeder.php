<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Todo;
use Illuminate\Support\Str;
class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Todo::factory()->count(100)->create([
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'title' => Str::random(10),
            'done' => random_int(0, 1),
            'created_at' => now('utc'),
            'updated_at' => now('utc'),
        ]);
    }
}
