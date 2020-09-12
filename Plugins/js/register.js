
// Fetching variables to be used later on! 
const username = document.getElementById('username')
const email = document.getElementById('email')
const pwd = document.getElementById('pwd')
const pwd2 = document.getElementById('pwd2')
const form = document.getElementById('form')

// Errors: 
const errorUsername = document.getElementById('errorUsername')
const errorEmail = document.getElementById('errorEmail')
const errorPwd = document.getElementById('errorPwd')
const errorPwd2 = document.getElementById('errorPwd2')

function printError(e, element, error, errorMessage) {
  e.preventDefault()
  error.innerText = errorMessage
  element.className += ' is-invalid'
}

function printSuccess(e, element, error) {
  error.innerText = ''
  element.className = 'form-control is-valid'
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

form.addEventListener('submit', (e) => {

  // Checking every field here!
  if (username.value === '' || username.value == null)
    printError(e, username, errorUsername, 'Username is required')
  else if (username.value.length < 4)
    printError(e, username, errorUsername, 'Username is too short')
  else if (username.value.length > 14)
    printError(e, usernam, errorUsername, 'Username is too long')
  else
    printSuccess(e, username, errorUsername)

  if (email.value === '' || email.value == null)
    printError(e, email, errorEmail, 'Email is required')
  else if (!isEmail(email.value))
    printError(e, email, errorEmail, 'Invalid email')
  else
    printSuccess(e, email, errorEmail)

  if (pwd.value === '' || pwd.value == null)
    printError(e, pwd, errorPwd, 'Password is required')
  else if (pwd.value.length < 5)
    printError(e, pwd, errorPwd, 'Password is too short')
  else if (pwd.value.length > 16)
    printError(e, pwd, errorPwd, 'Password is too long')
  else
    printSuccess(e, pwd, errorPwd)

  if (pwd2.value === '' || pwd2.value == null)
    printError(e, pwd2, errorPwd2, 'Password confirm is required')
  else if (pwd2.value !== pwd.value)
    printError(e, pwd2, errorPwd2, 'Passwords do not match')
  else
    printSuccess(e, pwd2, errorPwd2)

})



