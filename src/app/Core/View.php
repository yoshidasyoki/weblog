<?php

namespace App\Core;

class View
{
    public function __construct(private string $baseViewPath)
    {
    }

    public function render(string $viewPath, array $params = [])
    {
        extract($params);

        ob_start();
        include $this->baseViewPath . '/' . $viewPath . '.php';
        $content = ob_get_clean();
        return $content;
    }
}
