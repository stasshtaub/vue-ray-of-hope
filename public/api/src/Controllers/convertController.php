<?

namespace Controllers;

use Models\convertModel;

class convertController
{
    private $model;
    function __construct()
    {
        $this->model = new convertModel();
    }

    function convert($doc)
    {
        $filename = $doc['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        switch ($ext) {
            case "docx":
                if (mime_content_type($doc['tmp_name']) !== "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    throw new \Exception("BAD_FILE_FORMAT", 400);
                }
                $pdfPatch = $this->model->docxToPdf($doc['name'], $doc['tmp_name']);
                $jpgPath = $this->model->pdfToJpg(basename($pdfPatch), $pdfPatch);
                $this->output($jpgPath);
                http_response_code(200);
                unlink($pdfPatch);
                unlink($jpgPath);
                break;
            case "pdf":
                if (mime_content_type($doc['tmp_name']) !== "application/pdf") {
                    echo "case pdf";
                    throw new \Exception("BAD_FILE_FORMAT", 400);
                }
                $jpgPath = $this->model->pdfToJpg($doc['name'], $doc['tmp_name']);
                $this->output($jpgPath);
                http_response_code(200);
                unlink($jpgPath);
                break;
            default:
                echo "case default";
                throw new \Exception("BAD_FILE_FORMAT", 400);
        }
    }

    private function output($path, $contentType = "image/jpeg")
    {
        header("Content-Disposition: inline; filename=" . basename($path));
        header("Content-type: $contentType");
        readfile($path);
    }
}
