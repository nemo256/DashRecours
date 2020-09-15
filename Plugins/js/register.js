
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

function printSuccess(element, error) {
  error.innerText = ''
  element.className = 'form-control is-valid'
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

form.addEventListener('submit', (e) => {

  // Checking every field here!
  if (username.value === '' || username.value == null)
    printError(e, username, errorUsername, "Nom d'utilisateur est nécessaire")
  else if (username.value.length < 4)
    printError(e, username, errorUsername, "Nom d'utilisateur est trop court")
  else if (username.value.length > 14)
    printError(e, username, errorUsername, "Nom d'utilisateur est trop long")
  else
    printSuccess(username, errorUsername)

  if (email.value === '' || email.value == null)
    printError(e, email, errorEmail, 'Email est nécessaire')
  else if (!isEmail(email.value))
    printError(e, email, errorEmail, 'Email invalide')
  else
    printSuccess(email, errorEmail)

  if (pwd.value === '' || pwd.value == null)
    printError(e, pwd, errorPwd, 'Mot de passe est nécessaire')
  else if (pwd.value.length < 5)
    printError(e, pwd, errorPwd, 'Mot de passe est trop court')
  else if (pwd.value.length > 16)
    printError(e, pwd, errorPwd, 'Mot de passe est trop long')
  else
    printSuccess(pwd, errorPwd)

  if (pwd2.value === '' || pwd2.value == null)
    printError(e, pwd2, errorPwd2, 'Mot de passe est nécessaire')
  else if (pwd2.value !== pwd.value)
    printError(e, pwd2, errorPwd2, 'Mots de passe ne correspondent pas')
  else
    printSuccess(pwd2, errorPwd2)

})



