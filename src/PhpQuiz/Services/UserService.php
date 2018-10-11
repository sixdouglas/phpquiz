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
use PhpQuiz\Model\RoleModel;

class UserService
{
    protected $entityManager;
    protected $userRepository;
    protected $sessionService;
    protected $roleService;

    public function __construct()
    {
        $connect = new Connect();
        $this->entityManager = $connect->getEntityManager();
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->sessionService = new SessionService();
        $this->roleService = new RoleService();
    }

    /**
     * Return the encrypted password.
     */
    public static function cryptPassword($pwd)
    {
        //return md5($pwd);

        return crypt($pwd, 'px');
    }

    /**
     * Get user information from database if login/password is correct.
     *
     * @login user login
     * @password user password
     *
     * return the user
     */
    public function getUserFromLoginClearPwd($login, $password)
    {
        return $this->userRepository->findOneForLoginAndPassword($login, self::cryptPassword($password));
    }

    public function syncUser($user)
    {
        return $this->entityManager->merge($user);
    }

    public function detachUser($user)
    {
        $this->entityManager->detach($user);

        return $user;
    }

    /**
     * update the given user's password and save it.
     *
     * @user the current user
     * @password the new password
     *
     * return the updated user
     */
    public function updatePassword($user, $password)
    {
        $currentUser = $this->userRepository->findOneById($user->getId());
        $currentUser->setPassword(self::cryptPassword($password));
        $this->entityManager->persist($currentUser);
        $this->entityManager->flush();

        return $currentUser;
    }

    /**
     * lastname,firstname,email,login,password.
     */
    public function saveUsers($sessionId, $users)
    {
        $session = $this->sessionService->getSession($sessionId);
        $role = $this->roleService->findRoleFromCode(RoleModel::ROLE_STUDENT);
        $userLineArray = explode("\n", $users);
        $LASTNAME = 0;
        $FIRSTNAME = 1;
        $EMAIL = 2;
        $LOGIN = 3;
        $PASSWORD = 4;
        $arrayLength;
        foreach ($userLineArray as $key => $userLine) {
            if (strlen($userLine) < 1) {
                continue;
            }
            $userArray = explode(',', $userLine);
            if ($key === 0) {
                $arrayLength = count($userArray);
                foreach ($userArray as $key => $userProp) {
                    switch ($userProp) {
                        case 'lastname':
                            $LASTNAME = $key;
                            break;
                        case 'firstname':
                            $FIRSTNAME = $key;
                            break;
                        case 'email':
                            $EMAIL = $key;
                            break;
                        case 'login':
                            $LOGIN = $key;
                            break;
                        case 'password':
                            $PASSWORD = $key;
                            break;
                    }
                }
            } else {
                if (count($userArray) === $arrayLength) {
                    $this->addUser(
                        trim($userArray[$LASTNAME]),
                        trim($userArray[$FIRSTNAME]),
                        trim($userArray[$EMAIL]),
                        trim($userArray[$LOGIN]),
                        trim($userArray[$PASSWORD]),
                        $session,
                        $role
                    );
                }
            }
        }
    }

    /**
     * NOT USED.
     *
     * check if user login is already used
     *
     * @login user login
     *
     * return true if another user has already registerd with this login
     */
    public function isLoginAlreadyUsed($login)
    {
        return $this->userRepository->findOneBy(array('login' => $login)) != null;
    }

    /**
     * NOT USED.
     *
     * check if user email is already used
     *
     * @login user login
     *
     * return true if another user has already registerd with this email
     */
    public function isEmailUserAlreadyUsed($email)
    {
        return $this->userRepository->findOneBy(array('email' => $email)) != null;
    }

    /**
     * Create user into database and log him.
     *
     * @lastname user last name
     * @firstname user firstname
     * @email user email address
     * @login user login
     * @password user password
     *
     * return the updated user
     */
    public function addUser($lastname, $firstname, $email, $login, $password, $session, $role)
    {
        $user = new User();
        $user->setLogin($login);
        $user->setPassword(self::cryptPassword($password));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setSession($session);
        $user->setRole($role);
        $user = $this->entityManager->merge($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
