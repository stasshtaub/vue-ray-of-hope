<?

namespace Controllers;

use Core\Validator;
use Models\organizationModel;

class organizationController
{
    private $model;
    function __construct()
    {
        $this->model = new organizationModel();
    }

    function getOrg($id)
    {
        $result["profile"] = $this->model->getOrg($id);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    function getAll($type = null)
    {
        $result["organizations"] = $this->model->getOrgList($type);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    function edit(array $profileData)
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $errors = Validator::validateOrgProfile($profileData);
            if (!empty($errors)) {
                $result["status"] = "VALIDATE_ERROR";
                $result["errors"] = $errors;
                echo json_encode($result, JSON_PRETTY_PRINT);
                exit(422);
            }

            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            $result["status"] = "OK";
            $result["id"] = $this->model->editProfile($token, $profileData);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
}
