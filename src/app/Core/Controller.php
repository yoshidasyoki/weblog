<?php

namespace App\Core;

use App\Application;
use App\Core\DatabaseManager;

class Controller
{
    protected DatabaseManager $databaseManager;
    protected View $view;
    protected string $actionName;

    public function __construct(Application $app)
    {
        $this->databaseManager = $app->getDatabaseManager();
        $this->view = $app->getView();
    }

    public function run($actionName)
    {
        $this->actionName = $actionName;
        return $this->$actionName();
    }

    protected function render($template = null, $params = [])
    {
        $folderName = lcfirst($this->getControllerName());

        if (is_null($template)) {
            $template = $this->actionName;
        }

        $viewPath = $folderName . '/' . $template . '.php';

        return $this->view->render($viewPath, $params);
    }

    protected function getService()
    {
        $modelName = $this->getControllerName() . 'Model';
        $serviceName = 'App\\Services\\' . $this->getControllerName() . 'Service';
        $loginModel = $this->databaseManager->getModel($modelName);
        return new $serviceName($loginModel);
    }

    private function getControllerName(): string
    {
        $controller = str_replace('App\\Controllers\\', '', get_class($this));
        return str_replace('Controller', '', $controller);
    }
}
