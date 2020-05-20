<?

namespace Core;

use Core\DB;

abstract class baseUser
{
    protected function idFromToken($token)
    {
        $db = new DB();
        $query = "SELECT id FROM user WHERE token='$token'";
        $org = $this->DB->execute($query);
        if (!empty($org["id"])) {
            return $org["id"];
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
}
