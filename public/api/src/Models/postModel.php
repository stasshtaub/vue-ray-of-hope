<?

namespace Models;

use Core\DB;
use Exception;

class postModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function getOrganizationPosts($oid, $type)
    {
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type_note.name 'type', event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note INNER JOIN type_note ON note.type=type_note.id LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id WHERE note.author=$oid";
        if (!is_null($type)) {
            $query .= " AND type_note.name='$type'";
        }
        $posts = $this->DB->execute($query, null, true);
        foreach ($posts as $key => &$post) {
            $post = $this->modifyPost($post);
            $query = "SELECT image.id, image.url FROM image INNER JOIN note ON image.note=note.id WHERE note.id=" . $post["id"];
            $images = $this->DB->execute($query, null, true);
            $post["images"] = $images;
        }
        return $posts;
    }
    function getOrganizationPost($oid, $pid)
    {
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type_note.name 'type', event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note INNER JOIN type_note ON note.type=type_note.id LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id WHERE note.author=$oid AND note.id=$pid";
        $post = $this->DB->execute($query);
        if (empty($post)) {
            throw new Exception("NOT_FOUND", 404);
        }
        $post = $this->modifyPost($post);
        $query = "SELECT image.id, image.url FROM image INNER JOIN note ON image.note=note.id WHERE note.id=" . $post["id"];
        $images = $this->DB->execute($query, null, true);
        $post["images"] = $images;
        return $post;
    }

    function getFeed($filters)
    {
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type_note.name 'type', event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note INNER JOIN type_note ON note.type=type_note.id LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id";
        if (!empty($filters)) {
            $firstFilter = array_shift($filters);
            $firstKey = $firstFilter["dbName"];
            $firstVal = $firstFilter["value"];
            $where = " WHERE $firstKey='$firstVal'";
            foreach ($filters as $filter) {
                $key = $filter["dbName"];
                $value = $filter["value"];
                $where .= " AND $key='$value'";
            }
            $query .= $where;
        }
        $posts = $this->DB->execute($query, null, true);
        foreach ($posts as $key => &$post) {
            $post = $this->modifyPost($post);
            $query = "SELECT image.id, image.url FROM image INNER JOIN note ON image.note=note.id WHERE note.id=" . $post["id"];
            $images = $this->DB->execute($query, null, true);
            $post["images"] = $images;
        }
        return $posts;
    }

    function deletePost($oid, $pid)
    {
        $query = "DELETE FROM note WHERE id=:pid AND author=:oid";
        $params = [
            "oid" => $oid,
            "pid" => $pid
        ];
        return $this->DB->execute($query, $params);
    }

    function checkOwner($token, $postId)
    {
        $query = "SELECT CASE WHEN user.token='$token' THEN true ELSE false END isOwhner FROM note INNER JOIN user ON note.author=user.id WHERE note.id=$postId";
        return boolval($this->DB->execute($query)['isOwhner']);
    }

    private function modifyPost($post)
    {
        $modifiedPost = [
            "id" => $post["id"],
            "type" => $post["type"],
            "author" => [
                "id" => $post["authorId"],
                "name" => $post["name"],
                "avatar" => $post["avatar"]
            ],
            "text" => $post["text"],
            "date" => $post["date"]
        ];
        switch ($post["type"]) {
            case "event":
                $modifiedPost["eventData"] = [
                    "startDate" => $post["startDate"],
                    "endDate" => $post["endDate"],
                    "location" => $post["location"],
                ];
                break;
            case "need":
                $modifiedPost["needData"] = [
                    "needItems" => $post["needItems"],
                    "needCount" => $post["needCount"],
                    "collectedCount" => $post["collectedCount"]
                ];
                break;
        }
        return $modifiedPost;
    }
}
