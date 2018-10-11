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

class Application
{
    protected $route;
    protected $srcPath;
    protected $actions;
    protected $defaultAction;

    public function __construct($srcPath, $pathInfo)
    {
        $this->route = ltrim($pathInfo, '/');
        $this->srcPath = $srcPath;
        $this->actions = array();
    }

    public function setDefaultAction(\Closure $callback)
    {
        $this->defaultAction = $callback;
    }

    public function addAction($path, \Closure $callback)
    {
        $this->actions[$path] = $callback;
    }

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

    /**
     * @path: path defined for the current Action
     * @route: current HTTP Request route
     */
    public function validateRouteForPath($path, $route)
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

    private function callCallback($route, \Closure $callback)
    {
        $vars = $callback($route) ?: array();
        $vars['items']['baseUrl'] = $_SESSION['config']['site']['baseUrl'];

        return $vars;
    }

    private function renderPath($vars)
    {
        $pug = new \Pug();
        $pug->setOption('paths', [
            $this->srcPath,
        ]);
        $output = $pug->renderFile(__DIR__.'/'.$vars['items']['view'].'.pug', $vars);
        echo $output;
    }
}
