document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form[method="post"]');
  let isValid = false;

  const loginInput = document.querySelector('#login-input');
  const passwordInput = document.querySelector('input[type="password"]');

  const passwordTemplate = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;

  const submitButton = document.querySelector('button[type="submit"]');

  const inputIsInvalid = (isInvalid, input, message) => {
    const alertFeedback = input.nextElementSibling;
    if(isInvalid) {
      if(input.classList.contains('is-valid')) {
        input.classList.remove('is-valid');
        alertFeedback.classList.remove('valid-feedback');
      }
      input.classList.add('is-invalid');    
      alertFeedback.classList.add('invalid-feedback');
      submitButton.disabled = true;
      isValid = false;
    }
    else {
      if(input.classList.contains('is-invalid')) {
        input.classList.remove('is-invalid');
        alertFeedback.classList.remove('invalid-feedback');
      }  
      input.classList.add('is-valid');  
      alertFeedback.classList.add('valid-feedback');
      submitButton.disabled = false;
      isValid = true;
    }   
    alertFeedback.textContent = message;
  }

  loginInput.oninput = function() {
    if(loginInput.value == '') {
      if(loginInput.classList.contains('is-invalid')) {
        loginInput.classList.remove('is-invalid');
      }
      if(loginInput.classList.contains('is-valid')) {
        loginInput.classList.remove('is-valid');
      }
    }
    else if(parseInt(loginInput.value.substr(0, 1))) {
      inputIsInvalid(true, loginInput, "Логин должен начинаться с буквы");
    }
    else if(/^[a-zA-Z1-9]+$/.test(loginInput.value) === false) {
      inputIsInvalid(true, loginInput, "В логине должны быть только латинские буквы");
    }
    else if(loginInput.value.length < 3) {
      inputIsInvalid(true, loginInput, "Логин должен содержать не менее трёх символов");
    }
    else if(loginInput.value.length > 25) {
      inputIsInvalid(true, loginInput, "Слишком длинное имя пользователя");
    }
    else {
      inputIsInvalid(false, loginInput, "Логин соответствует требованиям");
    }
  }

  passwordInput.oninput = function () {
    if(passwordInput.value == '') {
      if(passwordInput.classList.contains('is-invalid')) {
        passwordInput.classList.remove('is-invalid');
      }
      if(passwordInput.classList.contains('is-valid')) {
        passwordInput.classList.remove('is-valid');
      }
    }
    else if(passwordInput.value.match(passwordTemplate)) {
      inputIsInvalid(false, passwordInput, "Пароль соответствует требованиям");
      isValid = true;
    }
    else {
      inputIsInvalid(true, passwordInput, "Пароль должен быть от 6 до 20 символов, содержать минимум одну цифру, одну заглавную и одну строчную букву");
      isValid = false;
    }
  }

  form.onsubmit = function () {
    if(isValid === false) {
      return false;
    }
  }
});