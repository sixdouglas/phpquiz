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
use PhpQuiz\Services\QuizService;

abstract class AbstractController
{
    protected $quizService;

    public function __construct()
    {
        $this->quizService = new QuizService();
    }

    protected function getQuizzes()
    {
        if (UserModel::isConnected()) {
            $quizzes = $this->quizService->findUserQuizzes(UserModel::getConnectedUser());
        } else {
            $quizzes = null;
        }

        return $quizzes;
    }

    protected function getQuiz($quizId)
    {
        return $this->quizService->getQuiz($quizId);
    }
}
