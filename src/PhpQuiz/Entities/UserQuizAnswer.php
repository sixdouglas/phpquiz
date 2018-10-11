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
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @Entity(repositoryClass="PhpQuiz\Repositories\UserQuizAnswerRepository")
 * @Table(name="user_quiz_answer")
 */
class UserQuizAnswer
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @Column(type="bigint")
     * @var bigint
     */
    protected $date;

    /**
     * @ManyToOne(targetEntity="UserQuiz")
     * @JoinColumn(name="user_quiz_id", referencedColumnName="id", nullable=true)
     **/
    protected $userQuiz;

    /**
     * @ManyToOne(targetEntity="Answer")
     * @JoinColumn(name="answer_id", referencedColumnName="id", nullable=true)
     **/
    protected $answer;

    public function getId()
    {
        return $this->id;
    }

    public function setCreationDate($time){
        $this->date = $time;
    }

    public function getCreationDate(){
        return $this->date;
    }

    public function getUserQuiz()
    {
        return $this->userQuiz;
    }

    public function setUserQuiz($userQuiz)
    {
        $this->userQuiz = $userQuiz;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Set date
     *
     * @param bigint $date
     * @return UserQuizAnswer
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return bigint $date
     */
    public function getDate()
    {
        return $this->date;
    }
}
