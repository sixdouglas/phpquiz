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

namespace PhpQuiz\Entities;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Table(name="quiz")
 * @Entity(repositoryClass="PhpQuiz\Repositories\QuizRepository")
 */
class Quiz
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $code;
    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $open;
    /**
     * @Column(type="integer", name="questions_count")
     * @var int
     */
    protected $questionsCount;
    /**
     * @OneToMany(targetEntity="Question", mappedBy="quiz", orphanRemoval=true)
     * @var Question[] An ArrayCollection of Question objects.
     **/
    protected $questions = null;
    /**
     * @OneToMany(targetEntity="UserQuiz", mappedBy="quiz", orphanRemoval=true)
     * @var UserQuiz[] An ArrayCollection of UserQuiz objects.
     **/
    protected $userQuizzes = null;
    /**
     * @ManyToOne(targetEntity="Session", inversedBy="quiz")
     **/
    protected $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->userQuizzes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getQuestionsCount()
    {
        return $this->questionsCount;
    }

    public function setQuestionsCount($questionsCount)
    {
        $this->questionsCount = $questionsCount;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function isOpen()
    {
        return $this->open;
    }

    public function setOpen($open)
    {
        $this->open = $open;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    public function getUserQuizzes()
    {
        return $this->userQuizzes;
    }

    public function setUserQuizzes($userQuizzes)
    {
        $this->userQuizzes = $userQuizzes;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get open
     *
     * @return boolean
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Add question
     *
     * @param \PhpQuiz\Entities\Question $question
     * @return Quiz
     */
    public function addQuestion(\PhpQuiz\Entities\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \PhpQuiz\Entities\Question $question
     */
    public function removeQuestion(\PhpQuiz\Entities\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Add userQuiz
     *
     * @param \PhpQuiz\Entities\UserQuiz $userQuiz
     * @return Quiz
     */
    public function addUserQuiz(\PhpQuiz\Entities\UserQuiz $userQuiz)
    {
        $this->userQuizzes[] = $userQuiz;

        return $this;
    }

    /**
     * Remove userQuiz
     *
     * @param \PhpQuiz\Entities\UserQuiz $userQuiz
     */
    public function removeUserQuiz(\PhpQuiz\Entities\UserQuiz $userQuiz)
    {
        $this->userQuizzes->removeElement($userQuiz);
    }
}
