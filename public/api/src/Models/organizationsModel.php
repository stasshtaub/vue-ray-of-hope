<?

namespace Models;

use Core\DB;

class organizationsModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function getOrgList($type)
    {
        $query = "SELECT user_id id, name, activity, avatar, description FROM organization INNER JOIN user ON organization.user_id=user.id";
        if (!is_null($type)) {
            $query .= " WHERE activity='$type'";
        }
        $organizations = $this->DB->execute($query, null, true);
        return $organizations;
    }

    function getOrg($id)
    {
        $query = "SELECT user.id, avatar, description, organization.name, phone, city.name city, region.name region, activity FROM user INNER JOIN organization ON user.id=organization.user_id LEFT JOIN city ON organization.city=city.id LEFT JOIN region ON city.region=region.code WHERE organization.user_id=$id";
        $profile = $this->DB->execute($query);
        if (!empty($profile)) {
            $profile["docs"] = $this->loadDocs($profile["id"]);
            return $profile;
        } else {
            throw new \Exception("NOT_FOUND", 404);
        }
    }

    private function loadDocs($oid)
    {
        $query = "SELECT id, url, preview FROM doc WHERE organization=$oid";
        $profile = $this->DB->execute($query, null, true);
        return $profile;
    }

    function editProfile($token, array $profileData)
    {
        $id = $this->idFromToken($token);
        $userTable = [];
        $orgTable = &$profileData;

        if (isset($orgTable['description'])) {
            $userTable['description'] = $orgTable['description'];
            unset($orgTable['description']);
        }
        if (isset($orgTable['avatar'])) {
            $file = $orgTable['avatar'];

            $path = "/content/organizations/" . $id . "/avatar." . pathinfo($file['name'], PATHINFO_EXTENSION);
            move_uploaded_file($file['tmp_name'], ROOT_DIR . "/..$path");
            $userTable['avatar'] = $path;
            unset($orgTable['avatar']);
        }

        if (!empty($userTable)) {
            $userSet = "";
            foreach ($userTable as $key => $value) {
                $userSet .= "$key=:$key,";
            }
            $userSet = chop($userSet, ',');

            $query = "UPDATE user SET $userSet WHERE id=$id";
            $this->DB->execute($query, $userTable);
        }

        if (!empty($orgTable)) {
            $orgSet = "";
            foreach ($orgTable as $key => $value) {
                $orgSet .= "$key=:$key, ";
            }
            $orgSet = chop($orgSet, ', ');
            $query = "UPDATE organization SET $orgSet WHERE user_id=$id";
            $this->DB->execute($query, $orgTable);
        }
        return $id;
    }

    private function idFromToken($token)
    {
        $query = "SELECT id FROM user WHERE token='$token'";
        $org = $this->DB->execute($query);
        if (!empty($org["id"])) {
            return $org["id"];
        } else {
            throw new \Exception("BAD_TOKEN", 401);
        }
    }
}
