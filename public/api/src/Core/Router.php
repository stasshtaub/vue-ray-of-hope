<?

namespace Core;

use Controllers;

class Router
{
    function start()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('POST', '/api/login/organization', [
                "controllerName" => "Controllers\\loginController",
                "method" => "loginOrganization"

            ]);
            $r->addRoute('POST', '/api/edit', [
                "controllerName" => "Controllers\\organizationController",
                "method" => "edit",
                "arrParams" => true
            ]);
            $r->addRoute('POST', '/api/convert', [
                "controllerName" => "Controllers\\convertController",
                "method" => "convert"
            ]);
            $r->addRoute('GET', '/api/organizations/{oid:\d+}/posts/{pid:\d+}', [
                "controllerName" => "Controllers\\postController",
                "method" => "getPostOrg"
            ]);
            $r->addRoute('GET', '/api/organizations/{oid:\d+}/posts[?\w+]', [
                "controllerName" => "Controllers\\postController",
                "method" => "getPostsOrg"
            ]);
            $r->addRoute('GET', '/api/organizations/{oid:\d+}', [
                "controllerName" => "Controllers\\organizationController",
                "method" => "getOrg"
            ]);
            $r->addRoute('GET', '/api/organizations', [
                "controllerName" => "Controllers\\organizationController",
                "method" => "getAll"
            ]);
            $r->addRoute('GET', '/api/feed[?\w+]', [
                "controllerName" => "Controllers\\postController",
                "method" => "getFeed",
                "arrParams" => true
            ]);
            $r->addRoute('GET', '/api/city[?\w+]', [
                "controllerName" => "Controllers\\cityController",
                "method" => "getCityList"
            ]);
            $r->addRoute('GET', '/api/dialogs', [
                "controllerName" => "Controllers\\dialogController",
                "method" => "getDialogs"
            ]);
            $r->addRoute('GET', '/api/dialogs/{id:\d+}', [
                "controllerName" => "Controllers\\dialogController",
                "method" => "getDialogs"
            ]);
            $r->addRoute('DELETE', '/api/organizations/{oid:\d+}/posts/{pid:\d+}', [
                "controllerName" => "Controllers\\postController",
                "method" => "delete"
            ]);
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                throw new \Exception("NOT_FOUND", 404);
                // ... 404 Not Found
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                throw new \Exception("METHOD_NOT_ALLOWED", 405);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $controller = new $handler["controllerName"]();
                $data = $handler["arrParams"] ? array($this->getData($httpMethod, $vars)) : $this->getData($httpMethod, $vars);
                call_user_func_array(array($controller, $handler["method"]), $data);
                break;
        }
    }

    private function getData($method, $vars = [])
    {
        $data = [];
        switch ($method) {
            case "POST":
                $data = $_POST;
                break;
            case "GET":
                $data = $_GET;
                break;
            default:
                $data = [];
                $exploded = explode('&', file_get_contents('php://input'));
                foreach ($exploded as $pair) {
                    $item = explode('=', $pair);
                    if (count($item) == 2) {
                        $data[urldecode($item[0])] = urldecode($item[1]);
                    }
                }
        }
        return array_merge($vars, $data, $_FILES);
    }
}
