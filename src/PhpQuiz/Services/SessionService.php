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
use PhpQuiz\Entities\Session;

class SessionService
{
    protected $entityManager;
    protected $sessionRepository;

    public function __construct()
    {
        $connect = new Connect();
        $this->entityManager = $connect->getEntityManager();
        $this->sessionRepository = $this->entityManager->getRepository(Session::class);
    }

    /**
     * Get the all Sessions.
     *
     * return the session[]
     */
    public function getSessions()
    {
        return $this->sessionRepository->findAll();
    }

    /**
     * Get the Session.
     *
     * @sessionId session's Id
     *
     * return the Session
     */
    public function getSession($sessionId)
    {
        return $this->sessionRepository->findOneById($sessionId);
    }
}
