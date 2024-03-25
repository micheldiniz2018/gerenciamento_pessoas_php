<?php

namespace routes;

use app\helpers\Request;
use app\helpers\Uri;
use Exception;

class Router
{
    /**
     * Set the base address for controllers.
     */
    public const CONTROLLER_NAMESPACE = 'app\\controllers';

    public static function load(string $controller, string $method)
    {
        try {
            /**
             * Get the controller and check if exists it.
             */
            $controllerNamespace = self::CONTROLLER_NAMESPACE . '\\' . $controller;
            if (!class_exists($controllerNamespace)) {
                throw new Exception("The Controller {$controller} doesn't exists.");
            }

            $controllerInstance = new $controllerNamespace;

            /**
             * Get the function and check if exists it.
             */
            if (!method_exists($controllerInstance, $method)) {
                throw new Exception("The function {$method} doesn't exists in controller {$controller}");
            }

            $controllerInstance->$method((object)$_REQUEST);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Set routes and types for requisitions.
     */
    public static function routes(): array
    {
        return [
            'get' => [
                '/cities_all' => fn () => self::load('UserCitiesController', 'showAll'),
                '/city_show' => fn () => self::load('UserCitiesController', 'show'),
                '/states_all' => fn () => self::load('UserStatesController', 'showAll'),
                '/state_show' => fn () => self::load('UserStatesController', 'show'),
                '/users_all' => fn () => self::load('UserController', 'showAll'),
                '/user_show' => fn () => self::load('UserController', 'show'),
                '/address_all' => fn () => self::load('UserAddressController', 'showAll'),
                '/address_show' => fn () => self::load('UserAddressController', 'show'),
            ],

            'post' => [
                '/city_store' => fn () => self::load('UserCitiesController', 'store'),
                '/state_store' => fn () => self::load('UserStatesController', 'store'),
                '/user_store' => fn () => self::load('UserController', 'store'),
                '/address_store' => fn () => self::load('UserAddressController', 'store'),
            ],

            'put' => [
                '/city_update' => fn () => self::load('UserCitiesController', 'update'),
                '/state_update' => fn () => self::load('UserStatesController', 'update'),
                '/user_update' => fn () => self::load('UserController', 'update'),
                '/address_update' => fn () => self::load('UserAddressController', 'update'),
            ],

            'delete' => [
                '/city_delete' => fn () => self::load('UserCitiesController', 'delete'),
                '/state_delete' => fn () => self::load('UserStatesController', 'delete'),
                '/user_delete' => fn () => self::load('UserController', 'delete'),
                '/address_delete' => fn () => self::load('UserAddressController', 'delete'),
            ],
        ] ;
    }

    /**
     * Call the routes.
     */
    public static function execute()
    {
        try {

            /**
             * Get routes, type request and URI.
             */
            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

            if (!isset($routes[$request])) {
                throw new Exception('Route doesn\'t exists');
            }

            /**
             * Get routes, type request and URI.
             */
            if (!array_key_exists($uri, $routes[$request])) {
                throw new Exception('Route doesn\'t exists');
            }

            $router = $routes[$request][$uri];

            if (!is_callable($router)) {
                throw new Exception("Route {$uri} is not callable");
            }

            $router();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

}