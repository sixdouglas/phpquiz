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

use PhpQuiz\Services\UserService;
use PhpQuiz\Services\QuizService;
use PhpQuiz\Services\SessionService;
use PhpQuiz\Services\UserQuizService;
use PhpQuiz\Model\UserModel;
use PhpQuiz\Application;

$app = new Application(__DIR__.'/src/PhpQuiz/templates', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($argv, $argv[1]) ? $argv[1] : ''));

$app->addAction(
    '/quiz/{1}',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        if (hasUserAnsweredQuiz($quizId)) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/viewquiz/'.$quizId);
            die();
        }

        $user = UserModel::getConnectedUser();
        $quizzes = getQuizzes();
        $quiz = getQuiz($quizId);
        $questions = getQuestions($quiz);
        $items = array(
            'view' => 'templates/quiz',
            'quizzes' => $quizzes,
            'quiz' => $quiz,
            'user' => $user,
            'questions' => $questions,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/savequiz/{1}',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];
        $quiz = saveQuiz($quizId);

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/viewquiz/'.$quizId);
        die();
    }
);

$app->addAction(
    '/viewquiz/{1}',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        if (!hasUserAnsweredQuiz($quizId)) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/quiz/'.$quizId);
            die();
        }

        $quizzes = getQuizzes();
        $user = UserModel::getConnectedUser();
        $userQuiz = getUserQuiz($user, $quizId);
        $items = array(
            'view' => 'templates/correctedQuiz',
            'quizzes' => $quizzes,
            'userQuiz' => $userQuiz,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/login',
    function ($route) {
        $userService = new UserService();
        $user = $userService->getUserFromLoginClearPwd($_POST['login'], $_POST['password']);
        if ($user != null) {
            UserModel::logUser($user);

            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = null;
        $items = null;
        $items = array(
            'view' => 'templates/index',
            'login' => $_POST['login'],
            'quizzes' => $quizzes,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/password',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $user = UserModel::getConnectedUser();
        $quizzes = getQuizzes();
        $items = array(
            'view' => 'templates/password',
            'user' => $user,
            'quizzes' => $quizzes,
            'showAlert' => false,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/savepassword',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $user = UserModel::getConnectedUser();

        if ($_POST['newPassword'] == $_POST['newRepeatPassword']) {
            if (strlen($_POST['newPassword']) >= 8) {
                $userService = new UserService();
                if ($user->getPassword() == $userService->cryptPassword($_POST['oldPassword'])) {
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
        $quizzes = getQuizzes();
        $items = array(
            'view' => 'templates/password',
            'user' => $user,
            'alert' => $alert,
            'showAlert' => true,
            'quizzes' => $quizzes,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/logout',
    function ($route) {
        UserModel::disconnect();

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
        die();
    }
);

$app->addAction(
    '/users',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = getQuizzes();
        $sessions = getSessions();
        $user = UserModel::getConnectedUser();
        $items = array(
            'view' => 'templates/users',
            'quizzes' => $quizzes,
            'sessions' => $sessions,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/saveusers',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        saveUsers();

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
        die();
    }
);

$app->addAction(
    '/results',
    function ($route) {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = getQuizzes();
        $sessions = getSessions();
        $user = UserModel::getConnectedUser();
        $items = array(
            'view' => 'templates/results',
            'quizzes' => $quizzes,
            'sessions' => $sessions,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/results/session/{1}',
    function ($route) {
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

        $quizzes = getQuizzes();
        $user = UserModel::getConnectedUser();
        $sessions = getSessions();
        $session = getSession($sessionId);
        $items = array(
            'view' => 'templates/results',
            'quizzes' => $quizzes,
            'user' => $user,
            'sessions' => $sessions,
            'session' => $session,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->addAction(
    '/results/session/{1}/quiz/{2}',
    function ($route) {
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

        $quizzes = getQuizzes();
        $user = UserModel::getConnectedUser();
        $sessions = getSessions();
        $session = getSession($sessionId);
        $quiz = getQuiz($quizId);
        $items = array(
            'view' => 'templates/results',
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
);

$app->setDefaultAction(
    function ($route) {
        $quizzes = null;
        $user = null;
        if (UserModel::isConnected()) {
            $user = UserModel::getConnectedUser();
            $quizzes = getQuizzes();
        }

        $items = array(
            'view' => 'templates/index',
            'quizzes' => $quizzes,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
);

$app->render();

function saveUsers()
{
    $userService = new UserService();
    $userService->saveUsers($_POST['session'], $_POST['users']);
}

function getSessions()
{
    $sessionService = new SessionService();

    return $sessionService->getSessions();
}

function getSession($sessionId)
{
    $sessionService = new SessionService();

    return $sessionService->getSession($sessionId);
}

function getQuizzes()
{
    if (UserModel::isConnected()) {
        $quizService = new QuizService();
        $quizzes = $quizService->findUserQuizzes(UserModel::getConnectedUser());
    } else {
        $quizzes = null;
    }

    return $quizzes;
}

function getQuiz($quizId)
{
    $quizService = new QuizService();
    $quiz = $quizService->getQuiz($quizId);

    return $quiz;
}

function getUserQuiz($user, $quizId)
{
    $userQuizService = new UserQuizService();

    return $userQuizService->getUserQuiz($user, $quizId);
}

function getQuestions($quiz)
{
    $quizIds = array_rand($quiz->getQuestions()->toArray(), 10);
    $questions = array();
    foreach ($quizIds as $quizId) {
        array_push($questions, $quiz->getQuestions()->toArray()[$quizId]);
    }

    shuffle($questions);

    return $questions;
}

function hasUserAnsweredQuiz($quizquizId)
{
    $userQuizService = new UserQuizService();

    return $userQuizService->hasUserAnsweredQuiz(UserModel::getConnectedUser()->getId(), $quizquizId);
}

function saveQuiz($quizId)
{
    $userQuizService = new UserQuizService();
    $quizService = new QuizService();
    $answers = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'check_') === 0) {
            $answers[$key] = $value;
        }
    }
    $quiz = $quizService->getQuiz($quizId);
    $user = UserModel::getConnectedUser();
    $userService = new UserService();
    $userQuizService->saveUserQuizAnswers($user, $quiz, $answers);

    return $quiz;
}
