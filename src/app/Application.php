<?php

namespace App;

use App\Core\EnvManager;
use App\Core\DatabaseManager;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\View;
use App\Exceptions\HttpNotFoundException;
use App\Helpers\TimeHelper;
use App\Middlewares\AuthMiddleware;

class Application
{
    private EnvManager $envManager;
    private DatabaseManager $databaseManager;
    private AuthMiddleware $authMiddleware;
    private Request $request;
    private Router $router;
    private View $view;
    private TimeHelper $timeHelper;

    public function __construct()
    {
        $this->envManager = new EnvManager();
        $this->databaseManager = new DatabaseManager();
        $this->authMiddleware = new AuthMiddleware();
        $this->request = new Request();
        $this->router = new Router($this->registerRouting());
        $this->view = new View(__DIR__ . '/views');
        $this->timeHelper = new TimeHelper();
    }

    public function run()
    {
        try {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'httponly' => true
            ]);
            session_start();

            $this->connectDatabase();

            $accessPath = $this->request->getAccessPath();
            $routing = $this->router->resolve($accessPath);
            if (!$this->authMiddleware->handle($accessPath)) {
                return Response::redirect('/login')->send();
            }

            $controllerName = 'App\\Controllers\\' . ucfirst($routing['controller']) . 'Controller';
            $actionName = $routing['action'];
            $response = $this->runAction($controllerName, $actionName);
            $response->send();
        } catch (HttpNotFoundException) {
            $content = $this->view->render('404page');
            Response::html(404, $content)->send();
        }
    }

    public function registerRouting()
    {
        return [
            '/' => ['controller' => 'home', 'action' => 'index'],
            '/login' => ['controller' => 'login', 'action' => 'index'],
            '/login/auth' => ['controller' => 'login', 'action' => 'auth'],
            '/register' => ['controller' => 'register', 'action' => 'index'],
            '/register/create' => ['controller' => 'register', 'action' => 'create'],
            '/logout' => ['controller' => 'login', 'action' => 'logout'],
            '/article' => ['controller' => 'article', 'action' => 'index'],
            '/article/write' => ['controller' => 'article', 'action' => 'write'],
            '/article/write/post' => ['controller' => 'article', 'action' => 'post'],
            '/history' => ['controller' => 'article', 'action' => 'history'],
            '/history/edit' => ['controller' => 'article', 'action' => 'edit'],
            '/history/edit/update' => ['controller' => 'article', 'action' => 'update'],
            '/history/edit/delete' => ['controller' => 'article', 'action' => 'delete']
        ];
    }

    private function runAction($controllerName, $actionName)
    {
        $controller = new $controllerName($this);
        return $controller->run($actionName);
    }

    private function connectDatabase(): void
    {
        $env = $this->envManager->run();
        $this->databaseManager->connectDatabase($env);
    }

    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getView(): View
    {
        return $this->view;
    }

    public function getTimeHelper(): TimeHelper
    {
        return $this->timeHelper;
    }
}
