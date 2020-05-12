<?

namespace Core;

class DB
{
    public $pdo;
    private $host = "localhost",
        $user = "root",
        $password = "",
        $db_name = "ray-of-hope",
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=UTF8";
        $this->pdo = new \PDO($dsn, $this->user, $this->password, $this->opt);
    }

    /**
     * @param mixed $query sql-запрос
     * @param array $params массив параметров
     * @param bool $fetchAll возвращать массив
     * 
     * @return void
     */
    public function execute($query, array $params = null, bool $fetchAll = false)
    {
        if (is_null($params)) {
            $count = ($this->pdo->query("select count(*) from ($query) q"))->fetchColumn();
            $stmt = $this->pdo->query($query);
            return $count > 1 || $fetchAll ? $stmt->fetchAll() : $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll() || $stmt;
    }
}
