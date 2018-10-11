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

 (function() {
    'use strict';
    window.addEventListener('load', function() {
      var passwordForm = document.getElementById('passwordChangeForm');
      passwordForm.addEventListener('submit', function(event) {
        var newInputPassword = document.getElementById('newInputPassword');
        var newRepeatInputPassword = document.getElementById('newRepeatInputPassword');
        var invalidFeedback = document.getElementById('invalidFeedback');
        if (newRepeatInputPassword.value !== newInputPassword.value || newInputPassword.value.length < 8) {
          newInputPassword.classList.add('is-invalid');
          newRepeatInputPassword.classList.add('is-invalid');
          invalidFeedback.style.display='block';
          event.preventDefault();
          event.stopPropagation();
        }else{
          newInputPassword.classList.remove('is-invalid');
          newRepeatInputPassword.classList.remove('is-invalid');
          invalidFeedback.style.display='none';
        }
      }, false);
  }, false);
})();
