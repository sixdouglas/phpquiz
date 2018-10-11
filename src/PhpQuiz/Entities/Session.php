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
 * @Entity(repositoryClass="PhpQuiz\Repositories\SessionRepository")
 * @Table(name="session")
 */
class Session
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
     * @OneToMany(targetEntity="Quiz", mappedBy="session", orphanRemoval=true)
     * @var Quiz[] An ArrayCollection of Quiz objects.
     **/
    protected $quizzes = null;
    /**
     * @OneToMany(targetEntity="User", mappedBy="session", orphanRemoval=true)
     * @var User[] An ArrayCollection of User objects.
     **/
    protected $users = null;

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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getQuizzes()
    {
        return $this->quizzes;
    }

    public function setQuizzes($quizzes)
    {
        $this->quizzes = $quizzes;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quiz = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Add quiz
     *
     * @param \PhpQuiz\Entities\Quiz $quiz
     * @return Quiz
     */
    public function addQuiz(\PhpQuiz\Entities\Quiz $quiz)
    {
        $this->quizzes[] = $quiz;

        return $this;
    }

    /**
     * Remove quiz
     *
     * @param \PhpQuiz\Entities\Quiz $quiz
     */
    public function removeQuiz(\PhpQuiz\Entities\Quiz $quiz)
    {
        $this->quizzes->removeElement($quiz);
    }

    /**
     * Add users
     *
     * @param \PhpQuiz\Entities\User $users
     * @return Session
     */
    public function addUser(\PhpQuiz\Entities\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \PhpQuiz\Entities\User $users
     */
    public function removeUser(\PhpQuiz\Entities\User $users)
    {
        $this->users->removeElement($users);
    }
}
