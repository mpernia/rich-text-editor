<?php

namespace Src\Domain\Contracts;

interface PdfTemplate
{
    public const TEMPLATE_EXTENSION = '.pdf';
    public const TEMPLATE = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>{{ title }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
            }
            h1 {
                text-align: center;
                color: #333;
            }
            .summary {
                font-style: italic;
                margin-bottom: 20px;
                padding: 10px;
                background: #f5f5f5;
            }
            .content {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
    <h1>{{ title }}</h1>
    <div class="summary">
        {{ summary }}
    </div>
    <div class="content">
        {{ content }}
    </div>
    </body>
    </html>
    HTML;
}
