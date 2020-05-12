<?

namespace Controllers;

use Models\postModel;

class feedController
{
    private $model;
    function __construct()
    {
        $this->model = new postModel();
    }

    function GET($type = null)
    {
        try {
            http_response_code(200);
            $result["status"] = "OK";
            $result["posts"] = $this->model->getFeed($type);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $result["status"] = $e->getMessage();
            http_response_code($e->getCode());
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
