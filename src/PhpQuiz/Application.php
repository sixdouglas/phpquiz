<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PhpQuiz;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\FileCacheReader;
use PhpQuiz\Controllers\Router;
use ReflectionClass;
use ReflectionMethod;

class Application
{
    protected $route;
    protected $srcPath;
    protected $controllers;
    protected $actions;
    protected $defaultAction;

    public function __construct($srcPath, $pathInfo, $controllers)
    {
        class_exists(Router::class, true);
        $this->route = ltrim($pathInfo, '/');
        $this->srcPath = $srcPath;
        $this->actions = array();
        $this->fillActions($controllers);
    }

    /*
        public function setDefaultAction(\Closure $callback)
        {
            $this->defaultAction = $callback;
        }

        public function addAction($path, \Closure $callback)
        {
            $this->actions[$path] = $callback;
        }
    */
    public function render()
    {
        $currentRoute = '';
        $currentCallback = $this->defaultAction;
        foreach ($this->actions as $path => $callback) {
            if ($this->validateRouteForPath($path, $this->route)) {
                $currentRoute = $this->route;
                $currentCallback = $callback;
                break;
            }
        }

        $vars = $this->callCallback($currentRoute, $currentCallback);
        $this->renderPath($vars);
    }

    private function fillActions($controllers)
    {
        if ($_SESSION['config']['annotation']['useCache']) {
            $reader = new FileCacheReader(
                new AnnotationReader(),
                $_SESSION['config']['annotation']['cacheDir'],
                $debug = true
            );
        } else {
            $reader = new AnnotationReader();
        }
        foreach ($controllers as $key => $controller) {
            $reflectionClass = new ReflectionClass($controller);
            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $key => $method) {
                $routerAnnotation = $reader->getMethodAnnotation($method, 'PhpQuiz\Controllers\Router');
                if ($routerAnnotation !== null) {
                    $methodCaller = new MethodCaller($controller, $method);
                    if ($routerAnnotation->defaultRoute) {
                        $this->defaultAction = $methodCaller;
                    } else {
                        $this->actions[$routerAnnotation->path] = $methodCaller;
                    }
                }
            }
        }
    }

    /**
     * @path: path defined for the current Action
     * @route: current HTTP Request route
     */
    private function validateRouteForPath($path, $route)
    {
        if (ltrim($path, '/') === $route) {
            return true;
        } else {
            if (strpos($path, '{') !== null) {
                $replaced = preg_replace('/{[a-zA-Z0-9]*}/', '[a-zA-Z0-9]*', ltrim($path, '/'));
                $replaced = '/^'.str_replace('/', '\/', $replaced).'$/';
                if (preg_match($replaced, $route)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function callCallback($route, $callback)
    {
        $vars = $callback->invoke($route) ?: array('view'=>'index');
        $vars['items']['baseUrl'] = $_SESSION['config']['site']['baseUrl'];

        return $vars;
    }

    private function renderPath($vars)
    {
        if ($_SESSION['config']['pug']['useCache']) {
            $pug = new \Pug(array(
                'cache' => $_SESSION['config']['pug']['cacheDir'],
                'basedir' => $_SESSION['config']['pug']['baseDir'],
                'upToDateCheck' => $_SESSION['config']['pug']['upToDateCheck'],
            ));
        } else {
            $pug = new \Pug();
        }
        $pug->setOption('paths', [
            $this->srcPath,
        ]);
        $output = $pug->renderFile($vars['items']['view'].'.pug', $vars);
        echo $output;
    }
}
