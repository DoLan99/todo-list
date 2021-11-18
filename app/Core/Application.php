<?php

namespace App\Core;

use App\Core\Router;
use App\Core\Request;
use App\Core\Database;
use App\Core\Response;
use App\Core\Session;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Database $db;
    public ?Controller $controller = null;
    public Session $session;
    public Template $template;

    public function __construct($rootPath, $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->template = new Template($rootPath.'/resources/views');
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}