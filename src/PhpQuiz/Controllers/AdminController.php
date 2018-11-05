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
use PhpQuiz\Model\UserModel;
use PhpQuiz\Services\SessionService;
use PhpQuiz\Services\UserService;

class AdminController extends AbstractController
{
    protected $sessionService;
    protected $userService;

    public function __construct()
    {
        parent::__construct();
        $this->sessionService = new SessionService();
        $this->userService = new UserService();
    }

    /**
     * @Router(path="/admin/quizzes")
     */
    public function quizzes($route)
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
        $user = UserModel::getConnectedUser();
        $items = array(
            'view' => 'admin/quizzes',
            'quizzes' => $quizzes,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/sessions")
     */
    public function sessions($route)
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
            'view' => 'admin/sessions',
            'quizzes' => $quizzes,
            'sessions' => $sessions,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/sessions/add")
     */
    public function addSession($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $this->doPersistSession($_POST["name"], $_POST["code"]);

        echo json_encode(array("added"=>"ok"));
        die();
    }

    /**
     * @Router(path="/admin/sessions/remove/{1}")
     */
    public function removeSession($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)/', $route, $ids);
        $sessionId = $ids[1];

        $this->doRemoveSession($sessionId);

        echo json_encode(array("removed"=>"ok"));
        die();
    }

    /**
     * @Router(path="/admin/sessions/edit/{1}")
     */
    public function editSession($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)/', $route, $ids);
        $sessionId = $ids[1];

        $this->doUpdateSession($sessionId, $_POST["name"], $_POST["code"]);

        echo json_encode(array("updated"=>"ok"));
        die();
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

    /**
     * @Router(path="/admin/results")
     */
    public function results($route)
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
            'view' => 'admin/results',
            'quizzes' => $quizzes,
            'sessions' => $sessions,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/results/session/{1}")
     */
    public function resultsSession($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)/', $route, $ids);
        $sessionId = $ids[1];

        $quizzes = $this->getQuizzes();
        $user = UserModel::getConnectedUser();
        $sessions = $this->getSessions();
        $session = $this->getSession($sessionId);
        $items = array(
            'view' => 'admin/results',
            'quizzes' => $quizzes,
            'user' => $user,
            'sessions' => $sessions,
            'session' => $session,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/results/session/{1}/quiz/{2}")
     */
    public function resultSessionQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)\/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $sessionId = $ids[1];
        $quizId = $ids[2];

        $quizzes = $this->getQuizzes();
        $user = UserModel::getConnectedUser();
        $sessions = $this->getSessions();
        $session = $this->getSession($sessionId);
        $quiz = $this->getQuiz($quizId);
        $items = array(
            'view' => 'admin/results',
            'quizzes' => $quizzes,
            'user' => $user,
            'sessions' => $sessions,
            'session' => $session,
            'quiz' => $quiz,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    private function doSaveUsers()
    {
        $this->userService->saveUsers($_POST['session'], $_POST['users']);
    }

    private function getSessions()
    {
        return $this->sessionService->getSessions();
    }

    private function getSession($sessionId)
    {
        return $this->sessionService->getSession($sessionId);
    }

    private function doRemoveSession($sessionId)
    {
        $this->sessionService->removeSession($sessionId);
    }

    private function doUpdateSession($sessionId, $name, $code)
    {
        $this->sessionService->updateSession($sessionId, $name, $code);
    }

    private function doPersistSession($name, $code)
    {
        $this->sessionService->persistSession($name, $code);
    }
}
