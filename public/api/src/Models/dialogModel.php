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
        $query = "SELECT m2.unread, CASE WHEN o.name IS NOT NULL THEN o.name ELSE c.name END 'interlocutorName', interlocutor.id interlocutorId, interlocutor.avatar interlocutorAvatar FROM message m JOIN user u1 ON u1.id=m.fromUser JOIN user u2 ON u2.id=m.toUser JOIN user interlocutor ON interlocutor.id IN (u1.id, u2.id) AND interlocutor.token<>'$token' LEFT JOIN organization o ON interlocutor.id=o.user_id LEFT JOIN civilian c ON interlocutor.id=c.user JOIN (SELECT fromUser, COUNT(case when onRead=0 then 1 else null end) unread FROM message GROUP BY fromUser) m2 ON m.fromUser=m2.fromUser JOIN user u3 ON u3.id=interlocutor.id WHERE '$token' IN (u1.token, u2.token) GROUP BY interlocutor.id";

        $dialogs = $this->DB->execute($query, null, true);
        foreach ($dialogs as &$dialog) {
            $dialog = [
                "id" => $dialog["interlocutorId"],
                "unread" => $dialog["unread"],
                "interlocutor" => [
                    "id" => $dialog["interlocutorId"],
                    "name" => $dialog["interlocutorName"],
                    "avatar" => $dialog["interlocutorAvatar"]
                ]
            ];
        }
        return $dialogs;
    }

    function getDialog($token, $interlocutorId)
    {
        $query = "SELECT m.* FROM message m JOIN user u1 ON u1.id=m.fromUser JOIN user u2 ON u2.id=m.toUser WHERE $interlocutorId IN (u1.id, u2.id) AND '$token' IN (u1.token, u2.token) ORDER BY m.id";
        $messages = $this->DB->execute($query, null, true);
        return $messages;
    }

    function sendMessage($from, $to, $msg)
    {
        $this->DB->ping();
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
