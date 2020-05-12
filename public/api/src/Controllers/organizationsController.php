<?

namespace Controllers;

use Models\organizationsModel;

class organizationsController
{
    private $model;
    function __construct()
    {
        $this->model = new organizationsModel();
    }

    function GET($type = null)
    {
        try {
            http_response_code(200);
            $result["status"] = "OK";
            $result["organizations"] = $this->model->getOrgList($type);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $result["status"] = $e->getMessage();
            http_response_code($e->getCode());
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
