<?php
declare(strict_types=1);


namespace Core;


/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var string
     */
    protected string $viewsPath = 'views/';

    /**
     * @param $viewName
     * @param array $params
     * @return false|string
     * @throws Exception
     */
    public function render($viewName, array $params = [])
    {
        $viewFileName = $this->viewsPath . $viewName . '.php';

        if (!file_exists($viewFileName)) {
            throw new Exception('View "' . $viewFileName . '" is not found');
        }

        if (is_array($params)) {
            extract($params, EXTR_SKIP);
        }

        ob_start();
        require $viewFileName;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}