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

namespace PhpQuiz\Controllers\Administration;

use PhpQuiz\Controllers\AbstractController;
use PhpQuiz\Controllers\Router;
use PhpQuiz\Model\UserModel;

class QuizAdminController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Router(path="/admin/quizzes")
     */
    public function quizzes($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $quizzes = $this->getQuizzes();
        $allQuizzes = $this->getAllQuizzes();

        $user = UserModel::getConnectedUser();
        $items = array(
            'view' => 'admin/quizzes',
            'quizzes' => $quizzes,
            'allQuizzes' => $allQuizzes,
            'user' => $user,
            'isConnected' => UserModel::isConnected(),
            'isAdmin' => UserModel::isAdminConnectedUser(),
        );

        return compact('items');
    }

    /**
     * @Router(path="/admin/quizzes/add")
     */
    public function addQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $this->doPersistQuiz($_POST["name"], $_POST["code"], $_POST["open"]);

        echo json_encode(array("added"=>"ok"));
        die();
    }

    /**
     * @Router(path="/admin/quizzes/remove/{1}")
     */
    public function removeQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        $this->doRemoveQuiz($quizId);

        echo json_encode(array("removed"=>"ok"));
        die();
    }

    /**
     * @Router(path="/admin/quizzes/edit/{1}")
     */
    public function editQuiz($route)
    {
        if (!UserModel::isConnected()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }
        if (!UserModel::isAdminConnectedUser()) {
            header('Location: '.$_SESSION['config']['site']['baseUrl'].'/');
            die();
        }

        $ids;
        preg_match('/[a-zA-Z\/]*\/([0-9]*)/', $route, $ids);
        $quizId = $ids[1];

        $this->doUpdateQuiz($quizId, $_POST["name"], $_POST["code"], $_POST["open"] === "true");

        echo json_encode(array("updated"=>"ok"));
        die();
    }

    protected function getAllQuizzes()
    {
        return $this->quizService->findAll();
    }

    private function doRemoveQuiz($quizId)
    {
        $this->quizService->removeQuiz($quizId);
    }

    private function doUpdateQuiz($quizId, $name, $code, $open)
    {
        $this->quizService->updateQuiz($quizId, $name, $code, $open);
    }

    private function doPersistQuiz($name, $code, $open)
    {
        $this->quizService->persistQuiz($name, $code, $open);
    }
}
