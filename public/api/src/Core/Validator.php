<?

namespace Core;

use Models\cityModel;

class Validator
{
    /**
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @param integer $inn
     * @param string $name
     * 
     * @return void
     */
    static function validateRegOrg(string $email, string $inn, string $password, string $confirmPassword, string $name)
    {
        $errors = [];
        if (strlen($password) && strlen($confirmPassword) && strlen($email) && strlen($inn) && strlen($name)) {
            if (strlen($password) < 8 || strlen($password) > 100 || preg_match("/^([^0-9]*|[^A-Z]*)$/", $password)) {
                $errors["password"] = "Некорректный пароль";
            } else if ($password != $confirmPassword) {
                $errors["confirmPassword"] = "Пароли не совпадают";
            }
            if (strlen($name) > 255) {
                $errors["name"] = "Название слишком длинное";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Некорректный email";
            }
            if (!static::validateInn($inn)) {
                $errors["inn"] = "Некорректный ИНН";
            }
        } else {
            $errors["empty"] = "Заполните все поля";
        }
        return $errors;
    }

    /** Проверяет валидность инн организации
     * @param integer $inn
     * @return void
     */
    private static function validateInn(string $inn)
    {
        if (preg_match('/\D/', $inn)) return false;

        $len = strlen($inn);

        if ($len === 10) {
            return $inn[9] === (string) (((2 * $inn[0] + 4 * $inn[1] + 10 * $inn[2] +
                3 * $inn[3] + 5 * $inn[4] +  9 * $inn[5] +
                4 * $inn[6] + 6 * $inn[7] +  8 * $inn[8]) % 11) % 10);
        } elseif ($len === 12) {
            $num10 = (string) (((7 * $inn[0] + 2 * $inn[1] + 4 * $inn[2] +
                10 * $inn[3] + 3 * $inn[4] + 5 * $inn[5] +
                9 * $inn[6] + 4 * $inn[7] + 6 * $inn[8] +
                8 * $inn[9]) % 11) % 10);

            $num11 = (string) (((3 * $inn[0] +  7 * $inn[1] + 2 * $inn[2] +
                4 * $inn[3] + 10 * $inn[4] + 3 * $inn[5] +
                5 * $inn[6] +  9 * $inn[7] + 4 * $inn[8] +
                6 * $inn[9] +  8 * $inn[10]) % 11) % 10);

            return $inn[11] === $num11 && $inn[10] === $num10;
        }

        return false;
    }

    static function validateOrgProfile(array $profileData)
    {
        $errors = [];
        foreach ($profileData as $key => $value) {
            switch ($key) {
                case 'name':
                    if (strlen($value) == 0) {
                        $errors[$key] = "Введите название";
                    } else if (strlen($value) > 255) {
                        $errors[$key] = "Название слишком длинное";
                    }
                    break;
                case 'description':
                    if (strlen($value) > 1000) {
                        $errors[$key] = "Описание слишком длинное";
                    }
                    break;
                case 'phone':
                    if (!preg_match('/[0-9-+_]*/', $value)) {
                        $errors[$key] = "Некорректный номер";
                    }
                    break;
                case 'city':
                    if (!static::checkInDB($value, 'city')) {
                        $errors[$key] = "Некорректный id города";
                    }
                    break;
                case 'avatar':
                    $tmpname = $value['tmp_name'];
                    $types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP, IMAGETYPE_WEBP];
                    if (!in_array(exif_imagetype($tmpname), $types)) {
                        $errors[$key] = "Некорректный формат изображения";
                    }
                    break;
            }
        }
        return $errors;
    }

    private static function checkInDB($id, $table)
    {
        require_once __DIR__ . "/DB.php";
        $DB = new DB();

        $query = "SELECT id FROM $table WHERE id=$id";
        $city = $DB->execute($query, null, true);
        return boolval(count($city));
    }

    public static function TokenAndIdMatch($token, $id)
    {
        require_once __DIR__ . "/DB.php";
        $DB = new DB();

        $query = "SELECT id FROM user WHERE token='$token' AND id=$id";
        $user = $DB->execute($query, null, true);
        return boolval(count($user));
    }
}
