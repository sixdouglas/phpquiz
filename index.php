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

require 'vendor/autoload.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['config'])) {
    $_SESSION['config'] = parse_ini_file(__DIR__.'/config/config.properties', true);
}

use PhpQuiz\Controllers\QuizController;
use PhpQuiz\Controllers\UserController;
use PhpQuiz\Controllers\AdminController;
use PhpQuiz\Controllers\DefaultController;
use PhpQuiz\Application;

$app = new Application(
    __DIR__.'/src/PhpQuiz/Templates',
    isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($argv, $argv[1]) ? $argv[1] : ''),
    array(QuizController::class, UserController::class, AdminController::class, DefaultController::class)
);

$app->render();
