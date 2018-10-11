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
use PhpQuiz\Entities\UserQuiz;
use PhpQuiz\Entities\UserQuizAnswer;

class UserQuizService
{
    protected $entityManager;
    protected $answerService;
    protected $quizService;
    protected $userQuizRepository;

    public function __construct()
    {
        $connect = new Connect();
        $this->entityManager = $connect->getEntityManager();
        $this->userQuizRepository = $this->entityManager->getRepository(UserQuiz::class);
        $this->answerService = new AnswerService();
        $this->quizService = new QuizService();
    }

    public function getUserQuiz($user, $quizId)
    {
        return $this->userQuizRepository->findOneByUserAndQuiz($user->getId(), $quizId);
    }

    /**
     * Save the user's answers for a quiz.
     *
     * @user the current user
     * @quiz the current quiz
     * @answers an array of answers
     */
    public function saveUserQuizAnswers($user, $quiz, $answers)
    {
        if (!$this->hasUserAnsweredQuiz($user->getId(), $quiz->getId())) {
            $this->saveUserAnswers($user, $quiz, $answers);
        }
    }

    /**
     * check if user already answer the quiz from database.
     *
     * @userId user id to look for in database
     * @quizId quiz id to look for in database
     *
     * return true if record exists
     */
    public function hasUserAnsweredQuiz($userId, $quizId)
    {
        return $this->userQuizRepository->findOneByUserAndQuiz($userId, $quizId) != null;
    }

    /**
     * save the user answers if they are possible ones.
     *
     * @user the current user
     * @quiz the current quiz
     * @answers the answers of the user to the quiz
     */
    private function saveUserAnswers($user, $quiz, $answers)
    {
        if ($this->validateAnswers($quiz, $answers)) {
            $userQuiz = new UserQuiz();
            $userQuiz->setDate(time());
            $userQuiz->setUser($user);
            $userQuiz->setQuiz($quiz);

            $userQuiz = $this->entityManager->merge($userQuiz);
            $goodAnswerCount = 0;

            foreach ($answers as $key => $value) {
                $userQuizAnswer = new UserQuizAnswer();
                $userQuizAnswer->setDate(time());
                $answer = $this->answerService->getAnswer($value);
                if ($answer->isGood()) {
                    ++$goodAnswerCount;
                }
                $userQuizAnswer->setAnswer($answer);
                $userQuizAnswer->setUserQuiz($userQuiz);

                $this->entityManager->merge($userQuizAnswer);
            }

            $userQuiz->setGoodAnswerCount($goodAnswerCount);
            $this->entityManager->persist($userQuiz);
            $this->entityManager->flush();
        }
    }

    /**
     * Check if the given answer are valid (if the exists as possible answers) for the current Quiz.
     *
     * @quiz the current quiz
     * @answers the array of answers
     *
     * return true if all given answers are possible, false otherwise
     */
    private function validateAnswers($quiz, $answers)
    {
        foreach ($answers as $key => $value) {
            $questionId = ltrim($key, 'check_');
            $answerId = $value;
            if ($this->quizService->isNotPossibleAnswer($quiz, $questionId, $answerId)) {
                throw new Exception('Answer: '.$answerId.' is not valid for the question '.$questionId
                    .' and quiz '.$quiz->getId());

                return false;
            }
        }

        return true;
    }
}
