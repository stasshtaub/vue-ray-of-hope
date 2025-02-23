<?

namespace Controllers;

use Models\postModel;
use Core\baseUser;
use Core\Validator;

class postController extends baseUser
{
    private $model;
    function __construct()
    {
        $this->model = new postModel();
    }

    function getPostsOrg($oid, $type = null)
    {
        $result["posts"] = $this->model->getOrganizationPosts($oid, $type);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    function getPostOrg($oid, $pid)
    {
        $result["post"] = $this->model->getOrganizationPost($oid, $pid);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    function newPost($postData)
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            //validation
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            if (!Validator::TokenAndIdMatch($token, $postData['oid'])) {
                throw new \Exception("BAD_TOKEN", 401);
            }
            $result["id"] = $this->model->newPost($postData);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }

    function getFeed($filters = null)
    {
        $allowedFilters = [
            "type" => [
                "dbName" => "type",
                "allowed" => ["note", "need", "event"]
            ],
            "city" => [
                "dbName" => "organization.city",
                "allowed" => "*"
            ],
        ];
        $allowedTypes = ["note", "need", "event"];
        foreach ($filters as $filterName => &$filerValue) {
            if (!isset($allowedFilters[$filterName]) || is_array($allowedFilters[$filterName]["allowed"]) && !in_array($filerValue, $allowedFilters[$filterName]["allowed"])) {
                throw new \Exception("NOT_ALLOWED_FILTER", 400);
            }
            $filerValue = [
                "dbName" => $allowedFilters[$filterName]["dbName"],
                "value" => $filerValue
            ];
        }
        $result["posts"] = $this->model->getFeed($filters);
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    function delete($oid, $pid)
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            if (!$this->model->checkOwner($token, $pid)) {
                throw new \Exception("NOT_OWNER", 400);
            }
            $this->model->deletePost($oid, $pid);
            $result["status"] = "OK";
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
}
