
// Fetching variables to be used later on! 
const nom = document.getElementById('nom')
const prenom = document.getElementById('prenom')
const email = document.getElementById('email')
const ddn = document.getElementById('ddn')
const add = document.getElementById('add')
const tel = document.getElementById('tel')
const TU = document.getElementById('select')
const form = document.getElementById('form')

// Errors: 
const errorNom = document.getElementById('errorNom')
const errorPrenom = document.getElementById('errorPrenom')
const errorEmail = document.getElementById('errorEmail')
const errorDdn = document.getElementById('errorDdn')
const errorSex = document.getElementById('errorSex')
const errorAdd = document.getElementById('errorAdd')
const errorTel = document.getElementById('errorTel')
const errorTU = document.getElementById('errorTU')

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
  if (nom.value === '' || nom.value == null)
    printError(e, nom, errorNom, 'Nom is required')
  else if (nom.value.length < 4)
    printError(e, nom, errorNom, 'Nom is too short')
  else if (nom.value.length > 14)
    printError(e, nom, errorNom, 'Nom is too long')
  else
    printSuccess(nom, errorNom)

  if (prenom.value === '' || prenom.value == null)
    printError(e, prenom, errorPrenom, 'Prenom is required')
  else if (prenom.value.length < 4)
    printError(e, prenom, errorPrenom, 'Prenom is too short')
  else if (prenom.value.length > 14)
    printError(e, prenom, errorPrenom, 'Prenom is too long')
  else
    printSuccess(prenom, errorPrenom)

  if (email.value === '' || email.value == null)
    printError(e, email, errorEmail, 'Email is required')
  else if (!isEmail(email.value))
    printError(e, email, errorEmail, 'Invalid email')
  else
    printSuccess(email, errorEmail)

  if (ddn.value === '' || ddn.value == null)
    printError(e, ddn, errorDdn, 'Date de naissance is required')
  else
    printSuccess(ddn, errorDdn)

  if (document.getElementById('radioPrimary1').checked)
    sex = 'Male'
  else if (document.getElementById('radioPrimary2').checked)
    sex = 'Female'
  else if (document.getElementById('radioPrimary3').checked)
    sex = 'Autre'
  else
    sex = null

  if (sex == null)
  {
    e.preventDefault()
    errorSex.innerText = 'Sex is required'
  }
  else
    errorSex.innerText = ''

  if (add.value === '' || add.value == null)
    printError(e, add, errorAdd, 'Adresse is required')
  else if (add.value.length < 4)
    printError(e, add, errorAdd, 'Adresse is too short')
  else if (add.value.length > 128)
    printError(e, add, errorAdd, 'Adresse is too long')
  else
    printSuccess(add, errorAdd)

  if (tel.value === '' || tel.value == null)
    printError(e, tel, errorTel, 'Numero de telephone is required')
  else if (tel.value.length < 10)
    printError(e, tel, errorTel, 'Numero de telephone is too short')
  else if (tel.value.length > 10)
    printError(e, tel, errorTel, 'Numero de telephone is too long')
  else
    printSuccess(tel, errorTel)

  if (TU.options[TU.selectedIndex].value == '')
    printError(e, TU, errorTU, 'Please select the type of user')
  else
  {
    // Not working because of ajax (ISSUE) X
    if (TU.options[TU.selectedIndex].value == 'Etudiant')
    {}
    else if (TU.options[TU.selectedIndex].value == 'Enseignant')
    {}
    else if (TU.options[TU.selectedIndex].value == 'Administrateur')
    {}
    else
      printError(e, TU, errorTU, 'Invalid user type!')
  }

})
