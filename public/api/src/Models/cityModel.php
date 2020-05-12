<?

namespace Models;

use Core\DB;

class cityModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function getCityList($searchStr)
    {
        $query = "SELECT city.id, city.name, region.name region FROM city INNER JOIN region ON city.region=region.code WHERE city.name LIKE '%$searchStr%' OR region.name LIKE '%$searchStr%' ORDER BY city.name limit 20";
        return $this->DB->execute($query, null, true);
    }
}
