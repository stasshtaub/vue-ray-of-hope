<?

namespace Models;

class convertModel
{
    function docxToPdf($docxName, $docxPath)
    {
        \PhpOffice\PhpWord\Settings::setPdfRendererPath(ROOT_DIR . "/vendor/mpdf/mpdf");
        \PhpOffice\PhpWord\Settings::setPdfRendererName('MPDF');

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxPath);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');

        if (!file_exists(ROOT_DIR . "/tmp")) {
            mkdir(ROOT_DIR . "/tmp");
        }

        $savePath = ROOT_DIR . "/tmp/" . pathinfo($docxName, PATHINFO_FILENAME) . ".pdf";
        $objWriter->save($savePath);
        return $savePath;
    }

    function pdfToJpg($pdfName, $pdfPath)
    {
        $pdf = new \Spatie\PdfToImage\Pdf($pdfPath);
        if (!file_exists(ROOT_DIR . "/tmp")) {
            mkdir(ROOT_DIR . "/tmp");
        }
        $savePath = ROOT_DIR . "/tmp/" . pathinfo($pdfName, PATHINFO_FILENAME) . ".jpg";
        if ($pdf->saveImage($savePath)) {
            return $savePath;
        } else {
            throw new \Exception("JPG_SAVE_ERROR", 500);
        }
    }
}
