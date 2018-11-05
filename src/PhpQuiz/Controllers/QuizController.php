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
use PhpQuiz\Services\UserQuizService;
use PhpQuiz\Model\UserModel;

class QuizController extends AbstractController
{
    protected $userQuizService;

    public function __construct()
    {
        parent::__construct();
        $this->userQuizService = new UserQuizService();
    }

    /**
     * @Router(path="/quiz/{1}")
     */
    public function quiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        if ($this->hasUserAnsweredQuiz($quizId)) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/viewquiz/'.$quizId);
            die();
        }

        $user = UserModel::getConnectedUser();
        $quizzes = $this->getQuizzes();
        $quiz = $this->getQuiz($quizId);
        $questions = $this->getQuestions($quiz);
        $items = array(
            'view' => 'quiz',
            'quizzes' => $quizzes,
            'quiz' => $quiz,
            'user' => $user,
            'questions' => $questions,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/savequiz/{1}")
     */
    public function saveQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];
        $quiz = $this->doSaveQuiz($quizId);

        header('Location: '.$_SESSION['config']['site']['baseUrl'].'/viewquiz/'.$quizId);
        die();
    }

    /**
     * @Router(path="/viewquiz/{1}")
     */
    public function viewQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        if (!$this->hasUserAnsweredQuiz($quizId)) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/quiz/'.$quizId);
            die();
        }

        $quizzes = $this->getQuizzes();
        $user = UserModel::getConnectedUser();
        $userQuiz = $this->getUserQuiz($user, $quizId);
        $items = array(
                'view' => 'correctedQuiz',
                'quizzes' => $quizzes,
                'userQuiz' => $userQuiz,
                'user' => $user,
                'isConnected' => UserModel::isConnected(),
                'isAdmin' => UserModel::isAdminConnectedUser(),
            );

        return compact('items');
    }

    private function getQuestions($quiz)
    {
        $quizIds = array_rand($quiz->getQuestions()->toArray(), 10);
        $questions = array();
        foreach ($quizIds as $quizId) {
            array_push($questions, $quiz->getQuestions()->toArray()[$quizId]);
        }

        shuffle($questions);

        return $questions;
    }

    private function hasUserAnsweredQuiz($quizquizId)
    {
        return $this->userQuizService->hasUserAnsweredQuiz(UserModel::getConnectedUser()->getId(), $quizquizId);
    }

    private function getUserQuiz($user, $quizId)
    {
        return $this->userQuizService->getUserQuiz($user, $quizId);
    }

    private function doSaveQuiz($quizId)
    {
        $answers = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'check_') === 0) {
                $answers[$key] = $value;
            }
        }
        $quiz = $this->quizService->getQuiz($quizId);
        $user = UserModel::getConnectedUser();
        $this->userQuizService->saveUserQuizAnswers($user, $quiz, $answers);

        return $quiz;
    }
}
