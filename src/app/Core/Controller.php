<?php

namespace App\Core;

use App\Application;
use App\Core\DatabaseManager;
use App\Core\View;
use App\Helpers\TimeHelper;

class Controller
{
    protected DatabaseManager $databaseManager;
    protected View $view;
    protected TimeHelper $timeHelper;
    protected string $actionName;

    protected $service;

    public function __construct(Application $app)
    {
        $this->databaseManager = $app->getDatabaseManager();
        $this->view = $app->getView();
        $this->timeHelper = $app->getTimeHelper();
        $this->service = $this->getService();
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

    private function getService()
    {
        $serviceName = 'App\\Services\\' . $this->getControllerName() . 'Service';
        return new $serviceName($this->databaseManager, $this->timeHelper);
    }

    private function getControllerName(): string
    {
        $controller = str_replace('App\\Controllers\\', '', get_class($this));
        return str_replace('Controller', '', $controller);
    }
}
