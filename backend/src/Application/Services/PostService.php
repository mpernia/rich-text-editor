<?php

namespace Src\Application\Services;

use Src\Application\Actions\Pdf\PdfGenerator;
use Src\Application\Actions\Post\PostCreator;
use Src\Application\Actions\Post\PostUpdater;
use Src\Application\Actions\RichText\RichTextGenerator;
use Src\Application\DataTransferObjects\PostDto;
use Src\Domain\Contracts\Entities\Post;

class PostService
{
    public static function create(PostDto $postDto, bool $inMarkdown = false): Post
    {
        $post = self::preparePost($postDto, $inMarkdown);
        return PostCreator::create($post);
    }

    public static function update(int|string $id, PostDto $postDto, bool $inMarkdown = false): Post
    {
        $post = self::preparePost($postDto, $inMarkdown);
        return PostUpdater::update($id, $post);
    }

    protected static function preparePost(PostDto $post, bool $inMarkdown): PostDto
    {
        $summary = !$inMarkdown
            ? RichTextGenerator::toHtml($post->getSummary())
            : RichTextGenerator::toMarkdown($post->getSummary());
        $content = !$inMarkdown
            ? RichTextGenerator::toHtml($post->getContent())
            : RichTextGenerator::toMarkdown($post->getContent());
        return new PostDto([
            'title' => $post->getTitle(),
            'summary' => $summary,
            'content' => $content,
            'user_id' => $post->getUserId(),
            'status_id' => $post->getStatusId()
        ]);
    }
}
