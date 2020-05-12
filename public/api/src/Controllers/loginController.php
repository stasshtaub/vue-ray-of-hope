<?

namespace Controllers;

use Models\loginModel;
// require_once ROOT_DIR . "/models/loginModel.php";
class loginController
{
    private $model;
    function __construct()
    {
        $this->model = new loginModel();
    }

    function loginOrganization()
    {
        $argsCount = func_num_args();
        $args = func_get_args();
        switch ($argsCount) {
            case 0:
                $headers = getallheaders();
                if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
                    $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
                    http_response_code(200);
                    $result["status"] = "OK";
                    $result["profile"] = $this->model->loginWithToken($token);
                    echo json_encode($result, JSON_PRETTY_PRINT);
                } else {
                    throw new \Exception("BAD_TOKEN", 401);
                }
                break;
            case 2:
                http_response_code(200);
                $result["status"] = "OK";
                $result["data"] = $this->model->login($args[0], md5($args[1] . 'ray-of-hope'));
                echo json_encode($result, JSON_PRETTY_PRINT);
                break;
            default:
                throw new \Exception("BAD_ARGUMENTS_COUNT", 401);
        }
    }
}
