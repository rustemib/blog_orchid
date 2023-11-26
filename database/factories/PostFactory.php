<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFiles = File::files(public_path('/images'));
        $randomImage = $imageFiles[rand(0, count($imageFiles) - 1)];

        return [
            'title' => $this->faker->words(rand(2, 3), true),
            'image' => 'images/' . $randomImage->getFilename(),
            'description' => $this->faker->sentence(rand(10, 15)),
            'body' => $this->faker->paragraphs(rand(20, 30), true),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
