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

namespace PhpQuiz\Model;

use PhpQuiz\Entities\User;

class UserModel
{
    public static function init($user)
    {
        if (!self::isConnected() && isset($_SESSION['userId'])) {
            self::setConnectedUser($user);
        }
    }

    /**
     * Set the user as current user.
     */
    public static function setConnectedUser($user)
    {
        $_SESSION['connectedUser'] = $user;
    }

    /**
     * Get the current user.
     */
    public static function getConnectedUser()
    {
        return $_SESSION['connectedUser'];
    }

    /**
     * To check if a user is connected.
     */
    public static function isConnected()
    {
        return isset($_SESSION['connectedUser']);
    }

    /**
     * define the user in session. To use from login page.
     */
    public static function logUser($user)
    {
        $_SESSION['userId'] = $user->getId();
        self::init($user);
    }

    /**
     * To logout the current user.
     */
    public static function disconnect()
    {
        $_SESSION['userId'] = null;
        self::setConnectedUser(null);
    }

    /**
     * Get the user name of the current user if there's one.
     */
    public static function getCurrentUserName()
    {
        if (self::isConnected()) {
            return self::getConnectedUser()->getFirstname();
        }

        return '';
    }

    /**
     * Get the user name of the current user if there's one.
     */
    public static function getCurrentRole()
    {
        if (self::isConnected()) {
            return self::getConnectedUser()->getRole();
        }

        return '';
    }

    /**
     * Get the current user's session.
     */
    public static function getCurrentSession()
    {
        if (self::isConnected()) {
            return self::getConnectedUser()->getSession();
        }

        return '';
    }

    /**
     * Get true if the current user has the admin role.
     */
    public static function isAdminConnectedUser()
    {
        if (UserModel::isConnected()) {
            return RoleModel::isAdmin(self::getCurrentRole());
        }

        return false;
    }
}
