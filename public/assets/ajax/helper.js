function validateForm(formSelector, rules) {

    let errors = {};
    let form = $(formSelector);

    $.each(rules, function(field, ruleString) {

        let ruleArray = ruleString.split('|');
        let value = $.trim(form.find("[name='" + field + "']").val() || '');

        ruleArray.forEach(function(rule) {

            // -------------------------
            // required
            // -------------------------
            if (rule === "required" && value === "") {
                addError(field, field + " is required.");

            }

            // -------------------------
            // email
            // -------------------------
            if (rule === "email" && value !== "" &&
                !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                addError(field, "Invalid email format.");
                
            }

            // -------------------------
            // name (only letters)
            // -------------------------
            if (rule === "name" && value !== "" &&
                !/^[A-Za-z ]+$/.test(value)) {
                addError(field, "Name must contain only letters.");
            }

            // -------------------------
            // username (letters, numbers, _)
            // -------------------------
            if (rule === "username" && value !== "" &&
                !/^[A-Za-z0-9_]{3,20}$/.test(value)) {
                addError(field, "Invalid username format.");
            }

            // -------------------------
            // mobile 10 digits
            // -------------------------
            if (rule === "mobile" && value !== "" &&
                !/^[0-9]{10}$/.test(value)) {
                addError(field, "Invalid mobile number (10 digits required).");
            }

            // -------------------------
            // numeric
            // -------------------------
            if (rule === "numeric" && value !== "" &&
                isNaN(value)) {
                addError(field, field + " must be numeric.");
            }

            // -------------------------
            // digits:x
            // -------------------------
            if (rule.startsWith("digits:")) {
                let digit = rule.split(":")[1];
                let regex = new RegExp("^\\d{" + digit + "}$");
                if (!regex.test(value)) {
                    addError(field, field + " must be " + digit + " digits.");
                }
            }

            // -------------------------
            // strong password
            // -------------------------
            if (rule === "password_strong" && value !== "" &&
                !/(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,}/.test(value)) {
                addError(field, "Password must contain uppercase, lowercase, digit & special char.");
            }

            // -------------------------
            // match:field
            // -------------------------
            if (rule.startsWith("match:")) {
                let matchField = rule.split(":")[1];
                let matchValue = $.trim(form.find("[name='" + matchField + "']").val() || '');
                if (value !== matchValue) {
                    addError(field, field + " must match " + matchField + ".");
                }
            }

            // -------------------------
            // date (YYYY-MM-DD)
            // -------------------------
            if (rule === "date" && value !== "" &&
                !/^\d{4}-\d{2}-\d{2}$/.test(value)) {
                addError(field, "Invalid date format (YYYY-MM-DD).");
            }

            // -------------------------
            // min length
            // -------------------------
            if (rule.startsWith("min:")) {
                let min = rule.split(":")[1];
                if (value.length < min) {
                    addError(field, field + " must be at least " + min + " characters.");
                }
            }

            // -------------------------
            // max length
            // -------------------------
            if (rule.startsWith("max:")) {
                let max = rule.split(":")[1];
                if (value.length > max) {
                    addError(field, field + " must not exceed " + max + " characters.");
                }
            }

            // -------------------------
            // min_value
            // -------------------------
            if (rule.startsWith("min_value:") && !isNaN(value)) {
                let min = rule.split(":")[1];
                if (parseFloat(value) < parseFloat(min)) {
                    addError(field, field + " must be at least " + min + ".");
                }
            }

            // -------------------------
            // max_value
            // -------------------------
            if (rule.startsWith("max_value:") && !isNaN(value)) {
                let max = rule.split(":")[1];
                if (parseFloat(value) > parseFloat(max)) {
                    addError(field, field + " must not exceed " + max + ".");
                }
            }

            // -------------------------
            // regex:/pattern/
            // -------------------------
            if (rule.startsWith("regex:")) {
                let pattern = rule.replace("regex:", "");
                let regex = new RegExp(pattern.slice(1, -1)); 
                if (!regex.test(value)) {
                    addError(field, field + " format is invalid.");
                }
            }

        });
    });

    function addError(field, msg) {
        if (!errors[field]) errors[field] = [];
        errors[field].push(msg);
    }

    return errors;
}


function remAlert(){
  document.getElementsByClassName('alert')[0].remove();
}


function setActive() {
  // Get the navbar container (adjust ID if needed)
  let navbar = document.getElementById('navbar-menu');
  if (!navbar) return; // Safety check

  // Get all anchor tags inside the navbar
  let a_tags = navbar.getElementsByTagName('a');

  // Get current page filename (e.g. "page-about2.php")
  let currentFile = window.location.pathname.split("/").pop();

  for (let i = 0; i < a_tags.length; i++) {
    let file = a_tags[i].getAttribute("href").split("/").pop();

    // Match the current file name with the link href
    if (file === currentFile) {
      a_tags[i].classList.add("active");
    } else {
      a_tags[i].classList.remove("active");
    }
  }
}

document.addEventListener("DOMContentLoaded", setActive);


function alert(type, msg,position='body') {
    let bs_class = (type == "success") ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
         <div class="alert ${bs_class}  alert-dismissible fade show" role="alert">
      <strong class="me-3">${msg}</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        `;
        
      if(position=='body'){
        document.body.append(element);
        element.classList.add('custom-alert');
      }
      else{
        document.getElementById(position).appendChild(element);
      }
        
        setTimeout(remAlert,2000);
}
