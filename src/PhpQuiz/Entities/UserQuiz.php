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
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Table(name="user_quiz")
 * @Entity(repositoryClass="PhpQuiz\Repositories\UserQuizRepository")
 */
class UserQuiz
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="userQuizzes")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     **/
    protected $user;

    /**
     * @Column(type="bigint")
     *
     * @var int
     */
    protected $date;

    /**
     * @Column(type="smallint", name="good_answer_count")
     *
     * @var int
     */
    protected $goodAnswerCount;

    /**
     * @ManyToOne(targetEntity="Quiz", inversedBy="userQuizzes")
     * @JoinColumn(name="quiz_id", referencedColumnName="id", nullable=true)
     **/
    protected $quiz;

    /**
     * @OneToMany(targetEntity="UserQuizQuestion", mappedBy="userQuiz", orphanRemoval=true, cascade={"all"})
     *
     * @var UserQuizQuestion[] an ArrayCollection of UserQuizQuestion objects
     **/
    protected $userQuizQuestions = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->userQuizQuestions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCreationDate($time)
    {
        $this->date = $time;
    }

    public function getCreationDate()
    {
        return $this->date;
    }

    public function getQuiz()
    {
        return $this->quiz;
    }

    public function setQuiz($quiz)
    {
        $this->quiz = $quiz;
    }

    public function getGoodAnswerCount()
    {
        return $this->goodAnswerCount;
    }

    public function setGoodAnswerCount($goodAnswerCount)
    {
        $this->goodAnswerCount = $goodAnswerCount;
    }

    /**
     * Set date.
     *
     * @param bigint $date
     *
     * @return UserQuiz
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return bigint
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user.
     *
     * @param \PhpQuiz\Entities\User $user
     *
     * @return UserQuiz
     */
    public function setUser(\PhpQuiz\Entities\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \PhpQuiz\Entities\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getUserQuizQuestions()
    {
        return $this->userQuizQuestions;
    }

    public function setUserQuizQuestions($userQuizQuestions)
    {
        $this->userQuizQuestions = $userQuizQuestions;
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
        $this->userQuizQuestion[] = $userQuizQuestion;

        return $this;
    }

    /**
     * Remove userQuizQuestion.
     *
     * @param \PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion
     */
    public function removeUserQuizQuestion(\PhpQuiz\Entities\UserQuizQuestion $userQuizQuestion)
    {
        $this->userQuizQuestion->removeElement($userQuizQuestion);
    }
}
