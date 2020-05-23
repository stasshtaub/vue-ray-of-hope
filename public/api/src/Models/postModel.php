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

    function newPost(array $postData)
    {
        $query = "INSERT INTO note (author, type, description) VALUE (:author, :type, :description)";
        $params = [
            "author" => $postData['oid'],
            "type" => $postData['type'],
            "description" => $postData['text']
        ];
        $this->DB->execute($query, $params);
        $noteId = $this->DB->pdo->lastInsertId();

        if (isset($postData['images'])) {
            $this->uploadImages($postData['oid'], $noteId, $postData['images']);
        }

        switch ($postData['type']) {
            case 'event':
                $query = "INSERT INTO event (note, start_date, end_date, address) VALUE (:note, :start_date, :end_date, :address)";
                $startDate = new \DateTime($postData['startDate']);
                $endDate = new \DateTime($postData['endDate']);
                $params = [
                    "note" => $noteId,
                    "start_date" => $startDate->format('Y-m-d'),
                    "end_date" => $endDate->format('Y-m-d'),
                    "address" => $postData['location']
                ];
                $this->DB->execute($query, $params);
                break;
            case 'need':
                $query = "INSERT INTO need (note, need_count, collected_count) VALUE (:note, :need_count, :collected_count)";
                $params = [
                    "note" => $noteId,
                    "need_count" => $postData['needCount'],
                    "collected_count" => $postData['collectedCount']
                ];
                $this->DB->execute($query, $params);
                break;
        }
        return $noteId;
    }

    private function uploadImages(int $oid, int $noteId, array $images)
    {
        $directory = "/content/organizations/$oid/posts/$noteId/images";
        $fullDirectory = ROOT_DIR . "/..$directory";
        if (!file_exists($fullDirectory)) {
            $createDirResult = mkdir($fullDirectory, 0777, true);
        }
        foreach ($images['name'] as $i => $fileName) {
            $path = "$fullDirectory/$fileName";
            if (move_uploaded_file($images['tmp_name'][$i], $path)) {
                $query = "INSERT INTO image (note, url) VALUE (:note, :url)";
                $params = [
                    "note" => $noteId,
                    "url" => str_replace(" ", "_", "$directory/$fileName"),
                ];
                $this->DB->execute($query, $params, false, true);
            }
        }
    }

    function getOrganizationPosts($oid, $type)
    {
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type, event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id WHERE note.author=$oid ORDER BY note.id DESC";
        if (!is_null($type)) {
            $query .= " AND type='$type'";
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
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type, event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id WHERE note.author=$oid AND note.id=$pid";
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
        $query = "SELECT note.id, note.author authorId, note.publication_date 'date', note.description 'text', type, event.start_date 'startDate', event.end_date 'endDate', event.address 'location', need.need_items 'needItems', need.need_count 'needCount', need.collected_count 'collectedCount', user.avatar, organization.name FROM note LEFT JOIN event ON note.id=event.note LEFT JOIN need ON note.id=need.note INNER JOIN user ON user.id=note.author INNER JOIN organization ON user.id=organization.user_id";
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

    function checkOwner($token, $noteId)
    {
        $query = "SELECT CASE WHEN user.token='$token' THEN true ELSE false END isOwhner FROM note INNER JOIN user ON note.author=user.id WHERE note.id=$noteId";
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
