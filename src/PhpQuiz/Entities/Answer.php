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

/**
 * @Entity(repositoryClass="PhpQuiz\Repositories\AnswerRepository")
 * @Table(name="answer")
 */
class Answer
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     *
     * @var int
     */
    protected $id;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $name;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $text;
    /**
     * @Column(type="boolean")
     *
     * @var bool
     */
    protected $good;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $reason;

    /**
     * @ManyToOne(targetEntity="Question", inversedBy="answers")
     **/
    protected $question;

    /**
     * @OneToMany(targetEntity="UserQuizQuestionAnswer", mappedBy="answer", orphanRemoval=true)
     * @var UserQuizQuestionAnswer[] An ArrayCollection of UserQuizQuestionAnswer objects.
     **/
    protected $userQuizQuestionAnswers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userQuizQuestionAnswers = new ArrayCollection();
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

    public function isGood()
    {
        return $this->good;
    }

    public function setGood($good)
    {
        $this->good = $good;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get good.
     *
     * @return bool
     */
    public function getGood()
    {
        return $this->good;
    }

    public function getUserQuizQuestionAnswers()
    {
        return $this->userQuizQuestionAnswers;
    }

    public function setUserQuizQuestionAnswers($userQuizQuestionAnswers)
    {
        $this->userQuizQuestionAnswers = $userQuizQuestionAnswers;
    }

    /**
     * Add userQuizQuestionAnswer
     *
     * @param \PhpQuiz\Entities\UserQuizQuestionAnswer $userQuizQuestionAnswer
     * @return UserQuizQuestion
     */
    public function addUserQuizQuestionAnswer(\PhpQuiz\Entities\UserQuizQuestionAnswer $userQuizQuestionAnswer)
    {
        $this->userQuizQuestionAnswers[] = $userQuizQuestionAnswer;

        return $this;
    }

    /**
     * Remove userQuizQuestionAnswer
     *
     * @param \PhpQuiz\Entities\UserQuizQuestionAnswer $userQuizQuestionAnswer
     */
    public function removeUserQuizQuestionAnswer(\PhpQuiz\Entities\UserQuizQuestionAnswer $userQuizQuestionAnswer)
    {
        $this->userQuizQuestionAnswers->removeElement($userQuizQuestionAnswer);
    }
}
