<?php

namespace Src\Application\Actions\RichText;

use Exception;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Src\Domain\Exceptions\ErrorConvertingToMarkdownException;

class RichTextGenerator
{
    protected const ENV_CONFIG = [
        'html_input' => 'allow',
        'allow_unsafe_links' => false,
        'max_nesting_level' => 100,
        'renderer' => [
            'soft_break' => "\n",
            'block_separator' => "\n\n",
        ]
    ];
    protected static ?MarkdownConverter $converter = null;

    public static function toHtml(string $text): string
    {
        if (empty($text)) {
            return '';
        }
        $sanitized = self::sanitizeHtml($text);
        return html_entity_decode(
            string: $sanitized,
            flags: ENT_QUOTES | ENT_HTML5,
            encoding: 'UTF-8'
        );
    }

    public static function toMarkdown(string $text): string
    {
        try {
            $text = self::cleanUtf8($text);
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = self::htmlToMarkdown($text);
            if (empty($text)) {
                throw new ErrorConvertingToMarkdownException('Empty text provided');
            }
            return $text;
        } catch (Exception $e) {
            logger()->error('Error converting to markdown:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new ErrorConvertingToMarkdownException($e->getMessage());
        }
    }

    protected static function cleanUtf8(string $text): string
    {
        $text = preg_replace_callback(
            pattern: '/<C3><([A-F0-9]{2})>/i',
            callback: function($matches) {
                return chr(hexdec('C3')) . chr(hexdec($matches[1]));
            },
            subject: $text
        );
        return $text;
    }

    protected static function convertInlineElements(string $text): string
    {
        $text = preg_replace('/<(strong|b)>(.*?)<\/(strong|b)>/is', '**$2**', $text);
        $text = preg_replace('/<(em|i)>(.*?)<\/(em|i)>/is', '*$2*', $text);
        $text = preg_replace('/<code>(.*?)<\/code>/is', '`$1`', $text);
        $text = preg_replace('/<a[^>]+href=["|\'](.*?)["|\'](.*?)>(.*?)<\/a>/is', '[$3]($1)', $text);
        return $text;
    }

    protected static function convertBlockElements(string $text): string
    {
        for ($i = 6; $i >= 1; $i--) {
            $text = preg_replace("/<h{$i}>(.*?)<\/h{$i}>/i", str_repeat('#', $i) . ' $1', $text);
        }
        $text = preg_replace_callback(
            pattern: '/<ul>(.*?)<\/ul>/is',
            callback: function($matches) {
                $content = $matches[1];
                $items = explode('</li>', $content);
                $markdown = "\n";
                foreach ($items as $item) {
                    $item = trim(strip_tags($item));
                        if (!empty($item)) {
                            $markdown .= "- $item\n";
                        }
                }
                return $markdown;
            },
            subject: $text
        );
        $text = preg_replace('/<p>(.*?)<\/p>/is', "$1\n\n", $text);
        return $text;
    }

    protected static function htmlToMarkdown(string $text): string
    {
        $text = self::convertBlockElements($text);
        $text = self::convertInlineElements($text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        return trim($text);
    }

    protected static function sanitizeHtml(string $html): string
    {
        $html = preg_replace('/<(script|style)\b[^>]*>.*?<\/(script|style)>/is', '', $html);
        $html = preg_replace('/\s+(on\w+)=["\'][^"\']*["\']/', '', $html);
        $html = str_replace(["\r\n", "\r"], "\n", $html);
        $html = preg_replace('/\n{3,}/', "\n\n", $html);
        $html = preg_replace('/<\/(p|div|h[1-6]|table|ul|ol)>(?!\n)/', "$0\n", $html);
        return trim($html);
    }

    protected static function getConverter(): MarkdownConverter
    {
        if (self::$converter === null) {
            $environment = new Environment(self::ENV_CONFIG);
            $environment->addExtension(new CommonMarkCoreExtension());
            $environment->addExtension(new GithubFlavoredMarkdownExtension());
            self::$converter = new MarkdownConverter($environment);
        }
        return self::$converter;
    }
}
