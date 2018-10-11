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

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PhpQuiz\Application;

final class ApplicationTest extends TestCase
{
    protected $app;

    protected function setUp(){
        $this->app = new Application('', '');
    }

    public function testValidateRouteForQuizPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/quiz/{1}', 'quiz/12')
        );
    }
    public function testValidateRouteForSaveQuizPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/savequiz/{1}', 'savequiz/21')
        );
    }
    public function testValidateRouteForViewQuizPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/viewquiz/{1}', 'viewquiz/11')
        );
    }
    public function testValidateRouteForLoginPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/login', 'login')
        );
    }
    public function testValidateRouteForPasswordPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/password', 'password')
        );
    }
    public function testValidateRouteForSavePasswordPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/savepassword', 'savepassword')
        );
    }
    public function testValidateRouteForLogoutPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/logout', 'logout')
        );
    }
    public function testValidateRouteForResultsPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/results', 'results')
        );
    }
    public function testValidateRouteForResultSessionPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/results/session/{1}', 'results/session/22')
        );
    }
    public function testInvalidateRouteForResultSessionQuizPath(): void
    {
        $this->assertEquals(
            false,
            $this->app->validateRouteForPath('/results/session/{1}', 'results/session/22/quiz/33')
        );
    }
    public function testValidateRouteForResultSessionQuizPath(): void
    {
        $this->assertEquals(
            true,
            $this->app->validateRouteForPath('/results/session/{1}/quiz/{2}', 'results/session/22/quiz/33')
        );
    }
    public function testNotValidateRouteForUnknownPath(): void
    {
        $this->assertEquals(
            false,
            $this->app->validateRouteForPath('/results', 'resultas')
        );
    }
}