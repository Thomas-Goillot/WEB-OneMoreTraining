/*
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
-------------------------------------------------------- 
*/
var currentTab = 0;
showTab(currentTab);

function showTab(n) {

  let tab = document.getElementsByClassName("tab");

  tab[n].style.display = "block";

  if (n == 0) {

    document.getElementById("prevBtn").style.display = "none";

  } else {

    document.getElementById("prevBtn").style.display = "inline";

  }
  if (n == (tab.length - 1)) {

    document.getElementById("nextBtn").innerHTML = "Valider";

  } else {

    document.getElementById("nextBtn").innerHTML = "Suivant";

  }

  fixStepIndicator(n)
}

function nextPrev(n) {

  let tab = document.getElementsByClassName("tab");

  if (n == 1 && !validateForm()) return false;

  tab[currentTab].style.display = "none";

  currentTab = currentTab + n;

  if (currentTab >= tab.length) {
    
    document.getElementById("regForm").submit();
    return false;

  }
  
  showTab(currentTab);
}

function validateForm() {

  let tab, input, i, valid = true;
  tab = document.getElementsByClassName("tab");
  input = tab[currentTab].getElementsByTagName("input");

  for (i = 0; i < input.length; i++) {

    if (input[i].value == "") {

      input[i].className += " is-invalid";

      valid = false;
    }
    else{

      let input_valid = true

      switch (currentTab) {
        case 0:
    
          switch (input[i].id) {    
            case "firstnameinput":
              if(input[i].value.length >= 20 || input[i].value.length <= 1) input_valid = false;
              break;
        
            case "lastnameinput":
              if(input[i].value.length >= 20 || input[i].value.length <= 1) input_valid = false;
              break;
        
            case "dayinput":
              if(input[i].value < 0 || input[i].value >= 31) input_valid = false;
              break;
        
            case "monthinput":
              if(input[i].value < 0 || input[i].value >= 12) input_valid = false;
              break;
            
            case "yearinput":
              if(isNaN(input[i].value)) input_valid = false;
              break;
            
            case "mailinput":
              if(mail_validate(input[i].value) !== true) input_valid = false;
              if(input[i+1].value != input[i].value) input_valid = false;
              break;
        
            case "mail2input":
              if(mail_validate(input[i].value) !== true) input_valid = false;
              if(input[i-1].value != input[i].value) input_valid = false;
              break;
        
            default:
              console.log("no input to check");
              break;
          }      
          break;
    
        case 1:
    
          break;  
    

        default:
          break;
      }
      
      if(input_valid) {
        input[i].className += " is-valid";
      }
      else {
        input[i].className += " is-invalid";
        valid = false;
      }

    }
  }

  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " bg-success";
  }

  return valid;
}

function fixStepIndicator(n) {

  let i, x = document.getElementsByClassName("step");

  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }

  x[n].className += " active";
}

