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

namespace PhpQuiz\Controllers;

use PhpQuiz\Controllers\Router;
use PhpQuiz\Model\UserModel;

class DefaultController extends AbstractController
{
    /**
     * @Router(defaultRoute=true)
     */
    public function defaultRoute($route)
    {
        $quizzes = null;
        $user = null;
        if (UserModel::isConnected()) {
            $user = UserModel::getConnectedUser();
            $quizzes = $this->getQuizzes();
        }

        $items = array(
            'view' => 'index',
            'quizzes' => $quizzes,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }
}
