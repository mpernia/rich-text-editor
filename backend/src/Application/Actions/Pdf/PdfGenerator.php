<?php

namespace Src\Application\Actions\Pdf;

use FPDF;
use Mustache_Engine;
use Mustache_Loader_ArrayLoader;
use Src\Application\DataTransferObjects\PdfDto;
use Src\Domain\Contracts\PdfTemplate;

class PdfGenerator
{
    public static function generate(PdfDto $pdfDto): string
    {
        $context = [
            'title' => $pdfDto->getTitle(),
            'summary' => $pdfDto->getSummary(),
            'content' => $pdfDto->getContent()
        ];
        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_ArrayLoader([
                'post' => PdfTemplate::TEMPLATE
            ])
        ]);
        $html = $mustache->render('post', $context);
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont($pdfDto::FONT_NAME, $pdfDto::FONT_TYPE_BOLD, $pdfDto::FONT_SIZE_TITLE);
        $pdf->Cell(0, 10, $pdfDto->getTitle(), 0, 1, $pdfDto::FONT_ALIGN_CENTER);
        $pdf->SetFont($pdfDto::FONT_NAME, $pdfDto::FONT_TYPE_NORMAL, $pdfDto::FONT_SIZE);
        $pdf->Ln();
        $pdf->MultiCell(0, 10, strip_tags($pdfDto->getSummary()));
        $pdf->Ln();
        $pdf->MultiCell(0, 10, strip_tags($pdfDto->getContent()));
        return $pdf->Output('S');
    }
}
