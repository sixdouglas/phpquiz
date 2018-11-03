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

namespace PhpQuiz\Controllers;

use PhpQuiz\Controllers\Router;
use PhpQuiz\Services\UserService;
use PhpQuiz\Model\UserModel;

class UserController extends AbstractController
{
    protected $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    /**
     * @Router(path="/login")
     */
    public function login($route)
    {
        $user = $this->userService->getUserFromLoginClearPwd($_POST['login'], $_POST['password']);
        if ($user != null) {
            UserModel::logUser($user);

            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = null;
        $items = null;
        $items = array(
                'view' => 'Templates/index',
                'login' => $_POST['login'],
                'quizzes' => $quizzes,
                'isConnected' => UserModel::isConnected(),
                'isAdmin' => UserModel::isAdminConnectedUser(),
            );

        return compact('items');
    }

    /**
     * @Router(path="/password")
     */
    public function password($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $user = UserModel::getConnectedUser();
        $quizzes = $this->getQuizzes();
        $items = array(
                'view' => 'Templates/password',
                'user' => $user,
                'quizzes' => $quizzes,
                'showAlert' => false,
                'isConnected' => UserModel::isConnected(),
                'isAdmin' => UserModel::isAdminConnectedUser(),
            );

        return compact('items');
    }

    /**
     * @Router(path="/savepassword")
     */
    public function savePassword($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $user = UserModel::getConnectedUser();

        if ($_POST['newPassword'] == $_POST['newRepeatPassword']) {
            if (strlen($_POST['newPassword']) >= 8) {
                if ($user->getPassword() == $this->userService->cryptPassword($_POST['oldPassword'])) {
                    $user = $userService->updatePassword($user, $_POST['newPassword']);
                    UserModel::setConnectedUser($user);

                    header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
                    die();
                } else {
                    $alert = 'Wrong old password';
                }
            } else {
                $alert = 'New password is too short. Need at least 8 caracters';
            }
        } else {
            $alert = 'New passwords don\'t match';
        }

        $user = UserModel::getConnectedUser();
        $quizzes = $this->getQuizzes();
        $items = array(
                'view' => 'Templates/password',
                'user' => $user,
                'alert' => $alert,
                'showAlert' => true,
                'quizzes' => $quizzes,
                'isConnected' => UserModel::isConnected(),
                'isAdmin' => UserModel::isAdminConnectedUser(),
            );

        return compact('items');
    }

    /**
     * @Router(path="/logout")
     */
    public function logout($route)
    {
        UserModel::disconnect();

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
        die();
    }
}
