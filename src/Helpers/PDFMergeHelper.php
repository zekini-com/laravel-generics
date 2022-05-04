<?php

declare(strict_types=1);

namespace Zekini\Generics\Helpers;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\View;
use Webklex\PDFMerger\Facades\PDFMergerFacade;


class PDFMergeHelper extends BaseHelper
{

    public static function mergeFromPath(array $pdfPaths): string
    {
        $path = storage_path('tmp');
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $merger = PDFMergerFacade::init();

        foreach ($pdfPaths as $path) {
            if (! file_exists(storage_path($path))) {
                throw new \InvalidArgumentException('invalid path given for merge');
            }

            $merger->addPDF(storage_path($path));
        }

        $merger->merge();

        return $merger->output();
    }

    public static function mergeFromView(array $pdfViews): string
    {
        $path = storage_path('tmp');
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
        
        $merger = PDFMergerFacade::init();

        foreach ($pdfViews as $view => $data) {
            if (! View::exists($view)) {
                throw new \InvalidArgumentException('invalid view given for pdf');
            }

            $pdf = SnappyPdf::loadView($view, $data)->output();

            $merger->addString($pdf);
        }

        $merger->merge();

        return $merger->output();
    }
}