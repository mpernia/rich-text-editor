<?php

namespace Src\Shared\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domain\Enums\StatusType;
use Src\Infrastructure\Persistences\Models\Post;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $formats = ['plain', 'html', 'markdown'];
        $format = $this->faker->randomElement($formats);

        $title = $this->faker->sentence;
        $content = '';
        $summary = '';

        switch ($format) {
            case 'plain':
                $content = $this->faker->paragraphs(3, true);
                $summary = $this->faker->paragraph;
                break;
            case 'html':
                $content = sprintf(
                    '<h1>%s</h1>\n<p>%s</p>\n<h2>%s</h2>\n<p>%s</p>\n<ul>\n<li>%s</li>\n<li>%s</li>\n</ul>',
                    $this->faker->sentence,
                    $this->faker->paragraph,
                    $this->faker->sentence,
                    $this->faker->paragraph,
                    $this->faker->sentence,
                    $this->faker->sentence
                );
                $summary = sprintf('<p>%s</p>', $this->faker->paragraph);
                break;
            case 'markdown':
                $content = sprintf(
                    '# %s\n\n%s\n\n## %s\n\n%s\n\n* %s\n* %s',
                    $this->faker->sentence,
                    $this->faker->paragraph,
                    $this->faker->sentence,
                    $this->faker->paragraph,
                    $this->faker->sentence,
                    $this->faker->sentence
                );
                $summary = $this->faker->paragraph;
                break;
        }

        return [
            'title' => $title,
            'content' => $content,
            'summary' => $summary,
            'status_id' => StatusType::DRAFT->value,
            'user_id' => 1,
            //'format' => $format,
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month')
        ];
    }
}
