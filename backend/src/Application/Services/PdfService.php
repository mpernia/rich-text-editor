<?php

namespace Src\Application\Services;

use Exception;
use Src\Application\Actions\{
    Pdf\PdfGenerator,
    Post\PostFinder,
    User\UserFinder
};
use RuntimeException;
use Src\Application\DataTransferObjects\PdfDto;
use Src\Domain\Exceptions\ErrorGeneratingPdfException;
use Src\Domain\Exceptions\PostNotFoundException;

class PdfService
{
    public static function create(int $id): string
    {
        try {
            $post = PostFinder::find($id);
            $user = UserFinder::find($post->getUserId());
            return PdfGenerator::generate(new PdfDto([
                'title' => $post->getTitle(),
                'summary' => $post->getSummary(),
                'content' => $post->getContent(),
                'author' => $user->getName() ?? 'Unknown'
            ]));
        } catch (PostNotFoundException $exception) {
            throw new PostNotFoundException($id);
        } catch (RuntimeException $exception) {
            throw new ErrorGeneratingPdfException;
        }
    }
}
