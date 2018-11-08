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
 * @Entity(repositoryClass="PhpQuiz\Repositories\QuestionRepository")
 * @Table(name="question")
 */
class Question
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
    protected $text;
    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $multiple;
    /**
     * @OneToMany(targetEntity="UserQuizQuestion", mappedBy="question", orphanRemoval=true)
     *
     * @var UserQuizQuestion[] an ArrayCollection of UserQuizQuestion objects
     **/
    protected $userQuizQuestions = null;
    /**
     * @OneToMany(targetEntity="Answer", mappedBy="question", orphanRemoval=true)
     * @var Anwser[] An ArrayCollection of Answer objects.
     **/
    protected $answers = null;
    /**
     * @ManyToOne(targetEntity="Quiz", inversedBy="questions")
     **/
    protected $quiz;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userQuizAnswers = new ArrayCollection();
        $this->answers = new ArrayCollection();
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

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
    }

    public function getQuiz()
    {
        return $this->quiz;
    }

    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }

    public function getUserQuizQuestions()
    {
        return $this->userQuizQuestions;
    }

    public function setUserQuizQuestions($userQuizQuestions)
    {
        $this->userQuizQuestions = $userQuizQuestions;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * Add userQuizQuestion.
     *
     * @param \PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion
     *
     * @return UserQuiz
     */
    public function addUserQuizQuestion(\PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion)
    {
        $this->userQuizQuestions[] = $userQuizQuestion;

        return $this;
    }

    /**
     * Remove userQuizQuestion.
     *
     * @param \PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion
     */
    public function removeUserQuizQuestion(\PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion)
    {
        $this->userQuizQuestions->removeElement($userQuizQuestion);
    }

    /**
     * Add answers
     *
     * @param \PhpQuiz\Entities\Answer $answers
     * @return Question
     */
    public function addAnswer(\PhpQuiz\Entities\Answer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \PhpQuiz\Entities\Answer $answers
     */
    public function removeAnswer(\PhpQuiz\Entities\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }
}
