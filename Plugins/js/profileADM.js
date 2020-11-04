
// Fetching variables to be used later on! 
const nom = document.getElementById('nom')
const prenom = document.getElementById('prenom')
const matricule = document.getElementById('matricule')
const TU = document.getElementById('select1')
const pwd = document.getElementById('pwd')
const pwd2 = document.getElementById('pwd2')
const form = document.getElementById('formADM')

// Updating a user!
const nomM = document.getElementById('nomM')
const prenomM = document.getElementById('prenomM')
const matriculeM = document.getElementById('matriculeM')
const TUM = document.getElementById('select2')
const pwdM = document.getElementById('pwdM')
const pwd2M = document.getElementById('pwd2M')
const formM = document.getElementById('formADMM')

// Errors:
const errorNom = document.getElementById('errorNom')
const errorPrenom = document.getElementById('errorPrenom')
const errorMatricule = document.getElementById('errorMatricule')
const errorTU = document.getElementById('errorTU')
const errorSex = document.getElementById('errorSex')
const errorPwd = document.getElementById('errorPwd')
const errorPwd2 = document.getElementById('errorPwd2')

// Updating a user!
const errorNomM = document.getElementById('errorNomM')
const errorPrenomM = document.getElementById('errorPrenomM')
const errorMatriculeM = document.getElementById('errorMatriculeM')
const errorTUM = document.getElementById('errorTUM')
const errorSexM = document.getElementById('errorSexM')
const errorPwdM = document.getElementById('errorPwdM')
const errorPwd2M = document.getElementById('errorPwd2M')

function printError(e, element, error, errorMessage) {
  e.preventDefault()
  error.innerText = errorMessage
  element.className += ' is-invalid'
}

function printSuccess(element, error) {
  error.innerText = ''
  element.className = 'form-control is-valid'
}

// Add a user: 
form.addEventListener('submit', (e) => {

  // Checking every field here!
  if (nom.value === '' || nom.value == null)
    printError(e, nom, errorNom, 'Nom est nécessaire')
  else if (nom.value.length < 4)
    printError(e, nom, errorNom, 'Nom est trop court')
  else if (nom.value.length > 14)
    printError(e, nom, errorNom, 'Nom est trop long')
  else
    printSuccess(nom, errorNom)

  if (prenom.value === '' || prenom.value == null)
    printError(e, prenom, errorPrenom, 'Prenom est nécessaire')
  else if (prenom.value.length < 4)
    printError(e, prenom, errorPrenom, 'Prenom est trop court')
  else if (prenom.value.length > 14)
    printError(e, prenom, errorPrenom, 'Prenom est trop long')
  else
    printSuccess(prenom, errorPrenom)

  if (matricule.value === '' || matricule.value == null)
    printError(e, matricule, errorMatricule, 'Matricule est nécessaire')
  else if (matricule.value.length < 4)
    printError(e, matricule, errorMatricule, 'Matricule est trop court')
  else if (matricule.value.length > 14)
    printError(e, matricule, errorMatricule, 'Matricule est trop long')
  else
    printSuccess(matricule, errorMatricule)

  if (TU.options[TU.selectedIndex].value == '')
    printError(e, TU, errorTU, "Veuillez sélectionner le type d'utilisateur")
  else
  {
    // Not working because of ajax (ISSUE) X
    if (TU.options[TU.selectedIndex].value == 'Etudiant' || TU.options[TU.selectedIndex].value == 'Enseignant')
      printSuccess(TU, errorTU)
    else
      printError(e, TU, errorTU, "Type d'utilisateur non valide!")
  }

  if (document.getElementById('radioPrimary1').checked)
    sex = 'Male'
  else if (document.getElementById('radioPrimary2').checked)
    sex = 'Female'
  else
    sex = null

  if (sex == null)
  {
    e.preventDefault()
    errorSex.innerText = 'Sexe est nécessaire'
  }
  else
    errorSex.innerText = ''

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

// Update a user: 
formM.addEventListener('submit', (e) => {

  // Checking every field here!
  if (nomM.value === '' || nomM.value == null)
    printError(e, nomM, errorNomM, 'Nom est nécessaire')
  else if (nomM.value.length < 4)
    printError(e, nomM, errorNomM, 'Nom est trop court')
  else if (nomM.value.length > 14)
    printError(e, nomM, errorNomM, 'Nom est trop long')
  else
    printSuccess(nomM, errorNomM)

  if (prenomM.value === '' || prenomM.value == null)
    printError(e, prenomM, errorPrenomM, 'Prenom est nécessaire')
  else if (prenomM.value.length < 4)
    printError(e, prenomM, errorPrenomM, 'Prenom est trop court')
  else if (prenomM.value.length > 14)
    printError(e, prenomM, errorPrenomM, 'Prenom est trop long')
  else
    printSuccess(prenomM, errorPrenomM)

  if (matriculeM.value === '' || matriculeM.value == null)
    printError(e, matriculeM, errorMatriculeM, 'Matricule est nécessaire')
  else if (matriculeM.value.length < 4)
    printError(e, matriculeM, errorMatriculeM, 'Matricule est trop court')
  else if (matriculeM.value.length > 14)
    printError(e, matriculeM, errorMatriculeM, 'Matricule est trop long')
  else
    printSuccess(matriculeM, errorMatriculeM)

  if (TUM.options[TUM.selectedIndex].value == '')
    printError(e, TUM, errorTUM, "Veuillez sélectionner le type d'utilisateur")
  else
  {
    // Not working because of ajax (ISSUE) X
    if (TUM.options[TUM.selectedIndex].value == 'Etudiant' || TUM.options[TUM.selectedIndex].value == 'Enseignant')
      printSuccess(TUM, errorTUM)
    else
      printError(e, TUM, errorTUM, "Type d'utilisateur non valide!")
  }

  if (document.getElementById('radio1').checked)
    sexM = 'Male'
  else if (document.getElementById('radio2').checked)
    sexM = 'Female'
  else
    sexM = null

  if (sexM == null)
  {
    e.preventDefault()
    errorSexM.innerText = 'Sexe est nécessaire'
  }
  else
    errorSexM.innerText = ''

  if (pwdM.value == '' && pwd2M.value != '')
    printError(e, pwdM, errorPwdM, 'Mot de passe est nécessaire')
  else if (pwdM.value != '')
  {
    if (pwdM.value.length < 5)
      printError(e, pwdM, errorPwdM, 'Mot de passe est trop court')
    else if (pwdM.value.length > 16)
      printError(e, pwdM, errorPwdM, 'Mot de passe est trop long')
    else if (pwd2M.value === '' || pwd2M == null)
      printError(e, pwd2M, errorPwd2M, 'Mot de passe est nécessaire')
    else if (pwdM.value != pwd2M.value)
    {
      printSuccess(pwdM, errorPwdM)
      printError(e, pwd2M, errorPwd2M, 'Mots de passe ne correspondent pas')
    }
    else
    {
      printSuccess(pwdM, errorPwdM)
      printSuccess(pwd2M, errorPwd2M)
    }
  }

})
