<?


namespace Controllers;

use Models\signupModel;
use Core\Validator;

// require_once ROOT_DIR . "/models/signupModel.php";
// require_once ROOT_DIR . "/core/Validator.php";
class signupController
{
    private $model;
    function __construct()
    {
        $this->model = new signupModel();
    }

    function POST(string $type, string $email, string $inn, string $password, string $confirmPassword, string $name)
    {
        switch ($type) {
            case "organization":
                $validateErrors = Validator::validateRegOrg($email, $inn, $password, $confirmPassword, $name);
                break;
            case "citizen":
                break;
            default:
                echo "Некорректный тип пользователя";
                exit(400);
        }
        if (empty($validateErrors)) {
            try {
                http_response_code(201);
                $result = $type == "organization" ? $this->model->registerOrg($email, $inn, $password, $name) : $this->model->registerCitizen();
                $result["status"] = "OK";
                echo json_encode($result, JSON_PRETTY_PRINT);
            } catch (\Exception $e) {
                http_response_code($e->getCode());
                $result["status"] = $e->getMessage();
                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        } else {
            http_response_code(422);
            $result["status"] = "VALIDATE_ERROR";
            $result["errors"] = $validateErrors;
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
