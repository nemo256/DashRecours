
// Fetching variables to be used later on! 
const nom = document.getElementById('nom')
const prenom = document.getElementById('prenom')
const matricule = document.getElementById('matricule')
const TU = document.getElementById('select1')
const pwd = document.getElementById('pwd')
const pwd2 = document.getElementById('pwd2')
const form = document.getElementById('formADM')

// Errors: 
const errorNom = document.getElementById('errorNom')
const errorPrenom = document.getElementById('errorPrenom')
const errorMatricule = document.getElementById('errorMatricule')
const errorTU = document.getElementById('errorTU')
const errorSex = document.getElementById('errorSex')
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

  if (matricule.value === '' || matricule.value == null)
    printError(e, matricule, errorMatricule, 'Matricule is required')
  else if (matricule.value.length < 4)
    printError(e, matricule, errorMatricule, 'Matricule is too short')
  else if (matricule.value.length > 14)
    printError(e, matricule, errorMatricule, 'Matricule is too long')
  else
    printSuccess(matricule, errorMatricule)

  if (TU.options[TU.selectedIndex].value == '')
    printError(e, TU, errorTU, 'Please select the type of user')
  else
  {
    // Not working because of ajax (ISSUE) X
    if (TU.options[TU.selectedIndex].value == 'Etudiant' || TU.options[TU.selectedIndex].value == 'Enseignant' || TU.options[TU.selectedIndex].value == 'Administrateur')
      printSuccess(TU, errorTU)
    else
      printError(e, TU, errorTU, 'Invalid user type!')
  }

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

  if (pwd.value === '' || pwd.value == null)
    printError(e, pwd, errorPwd, 'Password is required')
  else if (pwd.value.length < 5)
    printError(e, pwd, errorPwd, 'Password is too short')
  else if (pwd.value.length > 16)
    printError(e, pwd, errorPwd, 'Password is too long')
  else
    printSuccess(pwd, errorPwd)

  if (pwd2.value === '' || pwd2.value == null)
    printError(e, pwd2, errorPwd2, 'Password confirm is required')
  else if (pwd2.value !== pwd.value)
    printError(e, pwd2, errorPwd2, 'Passwords do not match')
  else
    printSuccess(pwd2, errorPwd2)

})
