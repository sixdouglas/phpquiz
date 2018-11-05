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

namespace PhpQuiz\Controllers\Administration;

use PhpQuiz\Controllers\AbstractController;
use PhpQuiz\Controllers\Router;
use PhpQuiz\Model\UserModel;
use PhpQuiz\Services\UserService;

class UserAdminController extends AbstractController
{
    protected $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    /**
     * @Router(path="/admin/users")
     */
    public function users($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = $this->getQuizzes();
        $sessions = $this->getSessions();
        $user = UserModel::getConnectedUser();
        $items = array(
            'view' => 'admin/users',
            'quizzes' => $quizzes,
            'sessions' => $sessions,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/saveusers")
     */
    public function saveUsers($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $this->doSaveUsers();

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
        die();
    }

    private function doSaveUsers()
    {
        $this->userService->saveUsers($_POST['session'], $_POST['users']);
    }
}
