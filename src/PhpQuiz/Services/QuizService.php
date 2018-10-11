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

namespace PhpQuiz\Services;

use PhpQuiz\Connect;
use PhpQuiz\Entities\User;
use PhpQuiz\Entities\Quiz;
use PhpQuiz\Model\UserModel;

class QuizService
{
    protected $entityManager;
    protected $quizRepository;

    public function __construct()
    {
        $connect = new Connect();
        $this->entityManager = $connect->getEntityManager();
        $this->quizRepository = $this->entityManager->getRepository(Quiz::class);
    }

    /**
     * Get user information from database if login/password is correct.
     *
     * @login user login
     * @password user password
     *
     * return the user
     */
    public function findUserQuizzes($user)
    {
        if (UserModel::isAdminConnectedUser()) {
            return $this->quizRepository->findByOpen(true);
        }

        return $this->quizRepository->findBySession($user->getSession());
    }

    /**
     * Get the Quizz.
     *
     * @quizzId quizz
     *
     * return the quiz
     */
    public function getQuiz($quizzId)
    {
        return $this->quizRepository->findById($quizzId);
    }

    public function isNotPossibleAnswer($quiz, $questionId, $answerId)
    {
        return $this->quizRepository->findQuestionAnswer($quiz->getId(), $questionId, $answerId) === null;
    }
}
