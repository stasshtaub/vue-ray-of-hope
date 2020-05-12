<?

namespace Controllers;

use Models\dialogModel;

class dialogController
{
    private $model;
    function __construct()
    {
        $this->model = new dialogModel();
    }

    function GET($dialogId = null)
    {
        try {
            $headers = getallheaders();
            if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
                $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
                if ($dialogId) {
                    $result["messages"] = $this->model->getDialog($token, $dialogId);
                } else {
                    $result["dialogs"] = $this->model->getDialogs($token);
                }
                http_response_code(200);
                $result["status"] = "OK";
                echo json_encode($result, JSON_PRETTY_PRINT);
            } else {
                throw new \Exception("BAD_TOKEN", 401);
            }
        } catch (\Exception $e) {
            $result["status"] = $e->getMessage();
            http_response_code($e->getCode());
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
