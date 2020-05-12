<?

namespace Controllers;

use Models\cityModel;

class cityController
{
    private $model;
    function __construct()
    {
        $this->model = new cityModel();
    }

    function getCityList($searchStr)
    {
        $result['status'] = 'OK';
        $result['cityList'] = $this->model->getCityList($searchStr);
        echo json_encode($result);
    }
}
