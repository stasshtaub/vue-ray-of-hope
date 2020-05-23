<?

namespace Controllers;

use Models\dialogModel;
use Core\baseUser;

class dialogController extends baseUser
{
    private $model;
    function __construct()
    {
        $this->model = new dialogModel();
    }

    function getDialogs($dialogId = null)
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            if ($dialogId) {
                $result["messages"] = $this->model->getDialog($token, $dialogId);
            } else {
                $result["dialogs"] = $this->model->getDialogs($token);
            }
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
    function sendMessage($to, $msg)
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            $from = $this->idFromToken($token);
            $result["message"] = $this->model->sendMessage($from, $to, $msg);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
}
