
var usererror = document.getElementById('username-error');
var userperror = document.getElementById('userp-error');
var emailerror = document.getElementById('email-error');
var cpwderror = document.getElementById('cpwd-error');
var pwderror = document.getElementById('pwd-error');
var userlabel=document.getElementById('username-label');
var userplabel=document.getElementById('userp-label');
var emaillabel=document.getElementById('email-label');
var pwdlabel=document.getElementById('pwd-label');
var cpwdlabel=document.getElementById('cpwd-label');
var submiterror = document.getElementById('submit-error');
function validateusername(){
    
    userlabel.style.bottom="30px";
   var name=document.getElementById('user-name').value;
   if(name.length == 0){
    usererror.innerHTML="le nom est obligatoire";
    return false;
   }

   else{
   usererror.innerHTML='<i class="fa-solid fa-circle-check"></i>';
   return true;}
   
}
function validateuserp(){
    
    userplabel.style.bottom="30px";
   var name=document.getElementById('user-name').value;
   if(name.length == 0){
    userperror.innerHTML="le prénom est obligatoire";
    return false;
   }

   else{
   userperror.innerHTML='<i class="fa-solid fa-circle-check"></i>';
   return true;}
   
}
function validatePhoneNumber() {
    var phoneNumber = document.getElementById('phone').value;
    var errorSpan = document.getElementById('phone-error');

    // Supprime les espaces, parenthèses, tirets et points du numéro de téléphone
    var cleanedPhoneNumber = phoneNumber.replace(/[\s()-.]/g, '');

    // Vérifie si le numéro de téléphone contient uniquement des chiffres
    if (!/^\d+$/.test(cleanedPhoneNumber)) {
        errorSpan.innerHTML = "Le numéro de téléphone invalid";
    } else if (!/^0[567]/.test(cleanedPhoneNumber)) {
        // Vérifie si le numéro commence par 07, 06, ou 05
        errorSpan.innerHTML = "Le numéro de téléphone invalid";
    }else if (cleanedPhoneNumber.length !== 10) {
        // Vérifie si le numéro de téléphone a une longueur valide (par exemple, 10 chiffres pour un numéro de téléphone standard)
        errorSpan.innerHTML = "Le numéro de téléphone invalid";
    }  else {
        // Réinitialise le message d'erreur s'il n'y a pas d'erreur
        errorSpan.innerHTML = "";
    }
}



function validateemail(){
    emaillabel.style.bottom="25px";
    var email = document.getElementById('email').value;
    if(email.length == 0){
        emailerror.innerHTML = 'email est obligatoire';
        return false;
    }
    if(!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)){
        emailerror.innerHTML= ' email invalide';
        return false;
    }
    emailerror.innerHTML='<i class="fa-solid fa-circle-check"></i>';
   return true;
}


function validatepwd(){
    
    pwdlabel.style.bottom="25px";
   var pwd=document.getElementById('pwd').value;
   if(pwd.length == 0){
    pwderror.innerHTML="le mot de passe est obligatoire";
    return false;
   }

   if(!pwd.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\S]{8,}$/)){
       pwderror.innerHTML="mot de passe invalide";
       return false;
   }
   else{
   pwderror.innerHTML='<i class="fa-solid fa-circle-check"></i>';
   return true;}
   
}

function validatecpwd(){
    
    cpwdlabel.style.bottom="25px";
   var cpwd=document.getElementById('cpwd').value;
   var pwd=document.getElementById('pwd').value;
   if(cpwd.length == 0){
    cpwderror.innerHTML="confirmer le mot de passe";
    return false;
   }

   if(cpwd !== pwd){
       cpwderror.innerHTML="mot de passe invalide";
       return false;
   }
   
     cpwderror.innerHTML='<i class="fa-solid fa-circle-check"></i>';
   return true;
   
   
}


  function validateform(){
    if(!validateusername() ||!validateuserp() || !validatecomp() || !validateemail() || !validatepwd() || !validatecpwd()){
        submiterror.style.display="block";
        submiterror.innerHTML="veuiller saisir tout les champs";
        return false;
    }
  }