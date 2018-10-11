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
 * @Table(name="user")
 * @Entity(repositoryClass="PhpQuiz\Repositories\UserRepository")
 */
class User
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
    protected $lastname;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $firstname;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $email;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $login;
    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $password;
    /**
     * @ManyToOne(targetEntity="Workgroup", inversedBy="users")
     **/
    protected $workgroup;
    /**
     * @ManyToOne(targetEntity="Session", inversedBy="users", fetch="EAGER")
     **/
    protected $session;
    /**
     * @ManyToOne(targetEntity="Role", inversedBy="users", fetch="EAGER")
     **/
    protected $role;
    /**
     * @OneToMany(targetEntity="UserQuiz", mappedBy="user", orphanRemoval=true)
     *
     * @var UserQuiz[] an ArrayCollection of UserQuiz objects
     **/
    protected $userQuizzes = null;

    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getWorkgroup()
    {
        return $this->workgroup;
    }

    public function setWorkgroup($workgroup)
    {
        $this->workgroup = $workgroup;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getUserQuizzes()
    {
        return $this->userQuizzes;
    }

    public function setUserQuizzes($userQuizzes)
    {
        $this->userQuizzes = $userQuizzes;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->userQuizzes = new ArrayCollection();
    }

    /**
     * Add userQuiz.
     *
     * @param \PhpQuiz\Entities\UserQuiz $userQuiz
     *
     * @return UserQuiz
     */
    public function addUserQuiz(\PhpQuiz\Entities\UserQuiz $userQuiz)
    {
        $this->userQuizzes[] = $userQuiz;

        return $this;
    }

    /**
     * Remove userQuiz.
     *
     * @param \PhpQuiz\Entities\UserQuiz $userQuiz
     */
    public function removeUserQuiz(\PhpQuiz\Entities\UserQuiz $userQuiz)
    {
        $this->userQuizzes->removeElement($userQuiz);
    }
}
