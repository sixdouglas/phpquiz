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
use PhpQuiz\Entities\Question;

class QuestionService
{
    protected $entityManager;
    protected $questionRepository;

    public function __construct()
    {
        $connect = new Connect();
        $this->entityManager = $connect->getEntityManager();
        $this->questionRepository = $this->entityManager->getRepository(Question::class);
    }

    /**
     * Get the Question.
     *
     * @questionId question
     *
     * return the question
     */
    public function getQuestion($questionId)
    {
        return $this->questionRepository->findOneById($questionId);
    }

    public function getQuestionGoodAnswerCount($question)
    {
        $multipleGoodAnswerCount = 0;
        foreach ($question->getAnswers() as $currentAnswer) {
            if ($currentAnswer->getGood()) {
                $multipleGoodAnswerCount++;
            }
        }
        return $multipleGoodAnswerCount;
    }

    public function removeQuestion($questionId)
    {
        $question = $this->getQuestion($questionId);
        $this->entityManager->remove($question);
        $this->entityManager->flush();
    }

    public function updateQuestion($questionId, $name, $code, $open)
    {
        $question = $this->getQuestion($questionId);
        $question->setName($name);
        $question->setCode($code);
        $question->setOpen($open);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }

    public function persistQuestion($name, $code, $open)
    {
        $question = new Question;
        $question->setName($name);
        $question->setCode($code);
        $question->setOpen($open);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }

    public function saveQuestion($question)
    {
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }
}
