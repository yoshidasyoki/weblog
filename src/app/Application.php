<?php

namespace App;

use App\Core\EnvManager;
use App\Core\DatabaseManager;
use App\Core\Request;
use App\Core\Router;
use App\Core\View;
use App\Middleware\AuthMiddleware;

class Application
{
    private EnvManager $envManager;
    private DatabaseManager $databaseManager;
    private AuthMiddleware $authMiddleware;
    private Request $request;
    private Router $router;
    private View $view;

    public function __construct()
    {
        $this->envManager = new EnvManager();
        $this->databaseManager = new DatabaseManager();
        $this->authMiddleware = new AuthMiddleware();
        $this->request = new Request();
        $this->router = new Router($this->registerRouting());
        $this->view = new View(__DIR__ . '/views');
    }

    public function run()
    {
        $this->connectDatabase();
        session_start();

        $accessPath = $this->request->getAccessPath();
        $this->authMiddleware->handle($accessPath);

        $routing = $this->router->resolve($accessPath);

        $controllerName = 'App\\Controllers\\' . ucfirst($routing['controller']) . 'Controller';
        $actionName = $routing['action'];
        $response = $this->runAction($controllerName, $actionName);
        $response->send();
    }

    public function registerRouting()
    {
        return [
            '/login' => ['controller' => 'login', 'action' => 'index'],
            '/login/auth' => ['controller' => 'login', 'action' => 'auth'],
            '/register' => ['controller' => 'register', 'action' => 'index'],
            '/register/create' => ['controller' => 'register', 'action' => 'create'],
            '/logout' => ['controller' => 'login', 'action' => 'logout'],
            '/home' => ['controller' => 'home', 'action' => 'index'],
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

    public function getView(): View
    {
        return $this->view;
    }
}
