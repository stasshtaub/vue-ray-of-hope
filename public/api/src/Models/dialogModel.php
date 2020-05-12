<?

namespace Models;

use Core\DB;
// require_once ROOT_DIR . "/core/DB.php";
class dialogModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function getDialogs($token)
    {
        $query = "SELECT m1.fromUser, m1.text, m2.unread FROM message m1 JOIN (SELECT fromUser, MAX(id) id, COUNT(case when onRead=0 then 1 else null end) unread FROM message GROUP BY fromUser ) m2 USING (fromUser, id) JOIN user ON user.id=m1.toUser WHERE token='$token'";
        return $this->DB->execute($query, null, true);
    }

    function getDialog($token, $from)
    {
        $query = "SELECT CASE WHEN o1.name IS NOT NULL THEN o1.name ELSE c1.name END 'fromName', u1.id fromId, u1.avatar fromAvatar, u1.type_of_account fromType, CASE WHEN o2.name IS NOT NULL THEN o2.name ELSE c2.name END 'toName', u2.id toId, u2.avatar toAvatar, u2.type_of_account toType, m.text FROM message m JOIN user u1 ON m.fromUser=u1.id LEFT JOIN organization o1 ON u1.id=o1.user_id LEFT JOIN civilian c1 ON u1.id=c1.user, user u2 LEFT JOIN organization o2 ON u2.id=o2.user_id LEFT JOIN civilian c2 ON u2.id=c2.user WHERE u1.id = m.fromUser AND u2.id = m.toUser AND u1.token='$token'";
        $messages = $this->DB->execute($query, null, true);
        foreach ($messages as &$msg) {
            $msg = [
                "from" => [
                    "id" => $msg["fromId"],
                    "name" => $msg["fromName"],
                    "avatar" => $msg["fromAvatar"]
                ],
                "to" => [
                    "id" => $msg["toId"],
                    "name" => $msg["toName"],
                    "avatar" => $msg["toAvatar"]
                ],
                "text" => $msg["text"]
            ];
        }
        return $messages;
    }

    function sendMessage($from, $to, $msg)
    {
        $query = "INSERT INTO message (fromUser, toUser, text) VALUE (:from, :to, :msg)";
        $params = [
            "from" => $from,
            "to" => $to,
            "msg" => $msg
        ];
        $this->DB->execute($query, $params);
        $query = "SELECT CASE WHEN o1.name IS NOT NULL THEN o1.name ELSE c1.name END 'fromName', u1.id fromId, u1.avatar fromAvatar, u1.type_of_account fromType, CASE WHEN o2.name IS NOT NULL THEN o2.name ELSE c2.name END 'toName', u2.id toId, u2.avatar toAvatar, u2.type_of_account toType, m.text FROM message m, user u1 LEFT JOIN organization o1 ON u1.id=o1.user_id LEFT JOIN civilian c1 ON u1.id=c1.user, user u2 LEFT JOIN organization o2 ON u2.id=o2.user_id LEFT JOIN civilian c2 ON u2.id=c2.user WHERE u1.id = m.fromUser AND u2.id = m.toUser AND m.id=" . $this->DB->pdo->lastInsertId();
        $msg = $this->DB->execute($query);
        return [
            "from" => [
                "id" => $msg["fromId"],
                "name" => $msg["fromName"],
                "avatar" => $msg["fromAvatar"]
            ],
            "to" => [
                "id" => $msg["toId"],
                "name" => $msg["toName"],
                "avatar" => $msg["toAvatar"]
            ],
            "text" => $msg["text"]
        ];
    }
}
