<?

namespace Models;

use Core\DB;
use Core\Token;
// require_once ROOT_DIR . "/core/DB.php";
// require_once ROOT_DIR . "/core/Token.php";
class loginModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function login($emailOrInn, $password)
    {
        $query = "SELECT user.id, avatar, description, organization.name, phone, city.name city, region.name region, activity FROM user INNER JOIN organization ON user.id=organization.user_id LEFT JOIN city ON organization.city=city.id LEFT JOIN region ON city.region=region.code  WHERE (user.email='$emailOrInn' OR organization.INN='$emailOrInn') AND user.password='$password'";
        $profile = $this->DB->execute($query);

        if (!empty($profile)) {
            $token = Token::generateToken();
            $uid = $profile["id"];
            $query = "UPDATE user SET token=:token WHERE id=:id";
            $params = [
                "token" => $token,
                "id" => $uid
            ];
            $this->DB->execute($query, $params);
            $profile["docs"] = $this->loadDocs($uid);
            return [
                "token" => $token,
                "profile" => $profile
            ];
        } else {
            echo "BAD_LOGIN_DATA excp";
            throw new \Exception("BAD_LOGIN_DATA", 401);
        }
    }

    function loginWithToken($token)
    {
        $query = "SELECT user.id, avatar, description, organization.name, phone, city.name city, region.name region, activity FROM user INNER JOIN organization ON user.id=organization.user_id LEFT JOIN city ON organization.city=city.id LEFT JOIN region ON city.region=region.code  WHERE user.token='$token'";
        $profile = $this->DB->execute($query);
        
        if (!empty($profile)) {
            $profile["docs"] = $this->loadDocs($profile["id"]);
            return $profile;
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }

    private function loadDocs($oid)
    {
        $query = "SELECT id, url, preview FROM doc WHERE organization=$oid";
        $profile = $this->DB->execute($query, null, true);
        return $profile;
    }
}
