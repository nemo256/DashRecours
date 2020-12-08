
// Fetching variables to be used later on! 
const module = document.getElementById('module')
const typeE = document.getElementById('typeE')
const emailens = document.getElementById('emailens')
const desc = document.getElementById('desc')
const semestre = document.getElementById('semestre')
const form = document.getElementById('formET')

// Modifier un recours
const module2 = document.getElementById('module2')
const typeE2 = document.getElementById('typeE2')
const emailens2 = document.getElementById('emailens2')
const desc2 = document.getElementById('desc2')
const semestre2 = document.getElementById('semestre2')
const form2 = document.getElementById('formET2')

// Errors: 
const errorModule = document.getElementById('errorModule')
const errorTypeE = document.getElementById('errorTypeE')
const errorEmailens = document.getElementById('errorEmailens')
const errorSemestre = document.getElementById('errorSemestre')
const errorDesc = document.getElementById('errorDesc')

// Modifier un recours
const errorModule2 = document.getElementById('errorModule2')
const errorTypeE2 = document.getElementById('errorTypeE2')
const errorEmailens2 = document.getElementById('errorEmailens2')
const errorSemestre2 = document.getElementById('errorSemestre2')
const errorDesc2 = document.getElementById('errorDesc2')

function printError(e, element, error, errorMessage) {
  e.preventDefault()
  error.innerText = errorMessage
  element.className += ' is-invalid'
}

function printSuccess(element, error) {
  error.innerText = ''
  element.className = 'form-control is-valid'
}

function printSuccessSelect(element, error) {
  error.innerText = ''
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

form.addEventListener('submit', (e) => {

  // Checking every field here!
  if (module.value === '' || module.value == null)
    printError(e, module, errorModule, 'Module est nécessaire')
  else if (module.value.length < 2)
    printError(e, module, errorModule, 'Module est trop court')
  else if (module.value.length > 15)
    printError(e, module, errorModule, 'Module est trop long')
  else
    printSuccessSelect(module, errorModule)

  if (semestre.value === '' || semestre.value == null)
    printError(e, semestre, errorSemestre, 'Semestre est nécessaire')
  else
    printSuccessSelect(semestre, errorSemestre)

  if (typeE.value === '' || typeE.value == null)
    printError(e, typeE, errorTypeE, 'Type est nécessaire')
  else if (typeE.value == 'Examin')
    printSuccessSelect(typeE, errorTypeE)
  else if (typeE.value == 'Test')
    printSuccessSelect(typeE, errorTypeE)
  else
    printError(e, typeE, errorTypeE, 'Type invalide')

  if (emailens.value === '' || emailens.value == null)
    printError(e, emailens, errorEmailens, 'Email (Enseignant) est nécessaire')
  else if (!isEmail(emailens.value))
    printError(e, emailens, errorEmailens, 'Email invalide')
  else
    printSuccessSelect(emailens, errorEmailens)

})

// Modifier un recours!
form2.addEventListener('submit', (e) => {

  // Checking every field here!
  if (module2.value === '' || module2.value == null)
    printError(e, module2, errorModule2, 'Module est nécessaire')
  else if (module2.value.length < 2)
    printError(e, module2, errorModule2, 'Module est trop court')
  else if (module2.value.length > 15)
    printError(e, module2, errorModule2, 'Module est trop long')
  else
    printSuccessSelect(module2, errorModule2)

  if (semestre2.value === '' || semestre2.value == null)
    printError(e, semestre2, errorSemestre2, 'Semestre est nécessaire')
  else
    printSuccessSelect(semestre2, errorSemestre2)

  if (typeE2.value === '' || typeE2.value == null)
    printError(e, typeE2, errorTypeE2, 'Type est nécessaire')
  else if (typeE2.value == 'Examin')
    printSuccessSelect(typeE2, errorTypeE2)
  else if (typeE2.value == 'Test')
    printSuccessSelect(typeE2, errorTypeE2)
  else
    printError(e, typeE2, errorTypeE2, 'Type invalide')

  if (emailens2.value === '' || emailens2.value == null)
    printError(e, emailens2, errorEmailens2, 'Email (Enseignant) est nécessaire')
  else if (!isEmail(emailens2.value))
    printError(e, emailens2, errorEmailens2, 'Email invalide')
  else
    printSuccessSelect(emailens2, errorEmailens2)

})


