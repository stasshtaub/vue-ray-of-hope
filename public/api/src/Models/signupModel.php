<?

namespace Models;

use Core\DB;
use Core\Token;

class signupModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }


    /**
     * @param string $email
     * @param integer $inn
     * @param string $password
     * @param string $name
     * 
     * @return void
     */
    function registerOrg(string $email, string $inn, string $password, string $name)
    {
        if ($this->isFree($email, $inn)) {
            $token = Token::generateToken();
            $query = "INSERT INTO user (type_of_account, email, password, token) VALUE (:type_of_account, :email, :password, :token)";
            $params = [
                "type_of_account" => "организация",
                "email" => $email,
                "password" => md5($password . 'ray-of-hope'),
                "token" => $token
            ];
            $this->DB->execute($query, $params);
            $uid = $this->DB->pdo->lastInsertId();

            $query = "INSERT INTO organization (user_id, INN, name) VALUE (:uid, :inn, :name)";
            $params = [
                "uid" => $uid,
                "inn" => $inn,
                "name" => $name
            ];
            $this->DB->execute($query, $params);

            $query = "SELECT user.id, avatar, description, organization.name, phone, city.name city, region.name region, activity FROM user INNER JOIN organization ON user.id=organization.user_id LEFT JOIN city ON organization.city=city.id LEFT JOIN region ON city.region=region.code WHERE user.id=$uid";
            $profile = $this->DB->execute($query);
            return [
                "profile" => $profile,
                "token" => $token
            ];
        } else {
            throw new \Exception("ORGANIZATION_ALREADY_EXIST", 409);
        }
    }

    function registerCitizen()
    {
    }
    /** Проверяет, свободен ли логин
     * @param string $login логин пользователя
     * @return bool true если свободен, false если нет
     * @throws \Exception
     */
    function isFree($email, $inn)
    {
        $query = "SELECT user.id FROM organization INNER JOIN user ON user.id=organization.user_id WHERE email='$email' OR inn='$inn'";
        $user = ($this->DB->execute($query));
        return empty($user[0]['id']) ? true : false;
    }
}
