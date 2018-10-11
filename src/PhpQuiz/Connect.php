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

namespace PhpQuiz;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Connect
{
    private $entityManager;

    public function __construct()
    {
        $isDevMode = $_SESSION['config']['general']['devMode'];
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/src'), $isDevMode);

        // database configuration parameters
        $conn = array(
            'driver' => $_SESSION['config']['database']['driver'],
            'user' => $_SESSION['config']['database']['user'],
            'password' => $_SESSION['config']['database']['password'],
            'dbname' => $_SESSION['config']['database']['dbname'],
        );

        // obtaining the entity manager
        $this->entityManager = EntityManager::create($conn, $config);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}