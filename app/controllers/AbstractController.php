<?php declare(strict_types=1);

namespace app\controllers;

use app\services\ServicesContainer;

abstract class AbstractController
{
    /** @var ServicesContainer */
    protected $services;

    /** @var array */
    protected $get;

    /** @var array */
    protected $post;

    public function __construct(ServicesContainer $services, array $routeParams)
    {
        $this->services = $services;
        $this->get = array_map('trim', array_merge($routeParams, $_GET));
        $this->post = array_map('trim', $_POST);
    }

    protected function renderView(string $viewAlias, array $vars = []) : void
    {
        echo $this->services->viewRenderer->render($viewAlias, $vars);
        exit();
    }

    /**
     * @param array|object|string $data
     */
    protected function renderJson($data) : void
    {
        header('Content-Type: application/json');

        if(is_string($data)) {
            echo $data;
        } elseif(is_array($data) || is_object($data)) {
            json_encode($data, JSON_THROW_ON_ERROR);
        } else {
            throw new \RuntimeException('Data type for JSON render is wrong');
        }

        exit();
    }

    protected function goBack() : void
    {
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    protected function redirect(string $toUrl, $code = 301) : void
    {
        header('Location: ' . $toUrl, true, $code);
        exit();
    }
}