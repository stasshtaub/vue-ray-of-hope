<?


namespace Controllers;

use Models\signupModel;
use Core\Validator;

class signupController
{
    private $model;
    function __construct()
    {
        $this->model = new signupModel();
    }

    function registration(string $email, string $inn, string $password, string $confirmPassword, string $name)
    {
        $validateErrors = Validator::validateRegOrg($email, $inn, $password, $confirmPassword, $name);
        if (empty($validateErrors)) {
            http_response_code(201);
            $result = $this->model->registerOrg($email, $inn, $password, $name);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            http_response_code(422);
            $result["status"] = "VALIDATE_ERROR";
            $result["errors"] = $validateErrors;
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
