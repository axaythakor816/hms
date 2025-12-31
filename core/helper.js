function validateForm(formSelector, rules) {

    let errors = {};
    let form = $(formSelector);

    $.each(rules, function(field, ruleString) {

        let ruleArray = ruleString.split('|');
        let element = form.find("[name='" + field + "']");
        let value = "";

        if (element.is(":radio")) {
            value = element.filter(":checked").val() || "";

        } else if (element.is(":checkbox")) {

            if (element.length > 1) {
                value = element.filter(":checked").length ? "checked" : "";
            } else {
                value = element.is(":checked") ? element.val() : "";
            }

        } else {
            value = $.trim(element.val() || "");
        }


        ruleArray.some(function(rule) {

            // required
            if (rule === "required" && value === "") {
                addError(field, capitalize(field) + " is required.");
                return true;
            }

            // email
            if (rule === "email" && value !== "" &&
                !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                addError(field, "Invalid email format.");
                return true;
            }

            // name (letters only)
            if (rule === "name" && value !== "" &&
                !/^[A-Za-z ]+$/.test(value)) {
                addError(field, "Name must contain only letters.");
                return true;
            }

            // username
           
            if (rule === "username" && value !== "") {

                let isUsername = /^[A-Za-z0-9_]{3,20}$/.test(value);
                let isMobile   = /^[0-9]{10}$/.test(value);
                let isEmail    = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

                if (!isUsername && !isMobile && !isEmail) {
                    addError(field, "Invalid UserName");
                    return true;
                }
            }

            // mobile
            if (rule === "mobile" && value !== "" &&
                !/^[0-9]{10}$/.test(value)) {
                addError(field, "Invalid mobile number (10 digits required).");
                return true;
            }

            // numeric
            if (rule === "numeric" && value !== "" && isNaN(value)) {
                addError(field, capitalize(field) + " must be numeric.");
                return true;
            }

            // digits:x
            if (rule.startsWith("digits:")) {
                let digit = rule.split(":")[1];
                if (!new RegExp("^\\d{" + digit + "}$").test(value)) {
                    addError(field, capitalize(field) + " must be " + digit + " digits.");
                    return true;
                }
            }

            // password_strong
            if (rule === "password_strong" && value !== "" &&
                !/(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,}/.test(value)) {

                addError(field, "Password must contain uppercase, lowercase, digit & special char.");
                return true;
            }

            // match:field
            if (rule.startsWith("match:")) {
                let matchField = rule.split(":")[1];
                let matchValue = $.trim(form.find("[name='" + matchField + "']").val() || '');

                if (value !== matchValue) {
                    addError(field, capitalize(field) + " does not match the " + capitalize(matchField.replace(/_/g, ' ').replace(/id/gi, '').trim()) + ".");
                    return true;
                }
            }

            // date
            if (rule === "date" && value !== "" &&
                !/^\d{4}-\d{2}-\d{2}$/.test(value)) {

                addError(field, "Invalid date format (YYYY-MM-DD).");
                return true;
            }

            // min:x
            if (rule.startsWith("min:")) {
                let min = parseInt(rule.split(":")[1]);
                if (value.length < min) {
                    addError(field, capitalize(field) + " must be at least " + min + " characters.");
                    return true;
                }
            }

            // max:x
            if (rule.startsWith("max:")) {
                let max = parseInt(rule.split(":")[1]);
                if (value.length > max) {
                    addError(field, capitalize(field) + " must not exceed " + max + " characters.");
                    return true;
                }
            }

            // min_value:x
            if (rule.startsWith("min_value:") && !isNaN(value)) {
                let min = parseFloat(rule.split(":")[1]);
                if (parseFloat(value) < min) {
                    addError(field, capitalize(field) + " must be at least " + min + ".");
                    return true;
                }
            }

            // max_value:x
            if (rule.startsWith("max_value:") && !isNaN(value)) {
                let max = parseFloat(rule.split(":")[1]);
                if (parseFloat(value) > max) {
                    addError(field, capitalize(field) + " must not exceed " + max + ".");
                    return true;
                }
            }

            // regex:/pattern/
            if (rule.startsWith("regex:")) {
                let pattern = rule.replace("regex:", "");
                pattern = pattern.slice(1, -1); // remove slashes: /pattern/
                let regex = new RegExp(pattern);

                if (!regex.test(value)) {
                    addError(field, capitalize(field) + " format is invalid.");
                    return true;
                }
            }

            // file:type:xxx
            if (rule.startsWith("file")) {
                let file = element[0]?.files[0];

                if (!file) {
                    return false; 
                }

                // type check
                let typeRule = rule.match(/type:([a-z0-9,]+)/i);
                if (typeRule) {
                    let allowedTypes = typeRule[1].split(",");
                    let fileExt = file.name.split(".").pop().toLowerCase();

                    if (!allowedTypes.includes(fileExt)) {
                        addError(
                            field,
                            capitalize(field) + " must be of type: " + allowedTypes.join(", ")
                        );
                        return true;
                    }
                }
            }

            // max_size:xKB / xMB
            if (rule.startsWith("max_size:")) {
                let file = element[0]?.files[0];
                if (!file) return false;

                let sizeValue = rule.split(":")[1].toUpperCase();
                let maxBytes = 0;

                if (sizeValue.endsWith("MB")) {
                    let mb = parseFloat(sizeValue.replace("MB", ""));
                    maxBytes = mb * 1024 * 1024;
                } 
                else if (sizeValue.endsWith("KB")) {
                    let kb = parseFloat(sizeValue.replace("KB", ""));
                    maxBytes = kb * 1024;
                } 
                else {
                    let mb = parseFloat(sizeValue);
                    maxBytes = mb * 1024 * 1024;
                }

                if (file.size > maxBytes) {
                    let readable = sizeValue.endsWith("KB") ? sizeValue : sizeValue + " MB";
                    addError(field, capitalize(field) + " must be  " + readable + " or smaller.");
                    return true;
                }
            }

            return false;
        });
    });

    function addError(field, msg) {
        let fieldName = field.replace(/_/g, ' ');

        fieldName = fieldName.replace(/id/gi, '').trim();

        if (fieldName) {
            fieldName = fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
        }

        if (!errors[field]) errors[field] = [];
        errors[field].push(msg.replace(capitalize(field), fieldName));
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    return errors;
}

function showAlert(type = "success", msg = "Message", position = "top-center") {

    let alertClass = (type === "success") ? "alert-success" : "alert-danger";
    // console.log("function message", msg);
    // Remove old alert
    $(".custom-alert-wrapper").remove();

    // Position classes
    let positions = {
        "top-left": "top:20px; left:20px;",
        "top-center": "top:20px; left:50%; transform:translateX(-50%);",
        "top-right": "top:20px; right:20px;",
        
        "bottom-left": "bottom:20px; left:20px;",
        "bottom-center": "bottom:20px; left:50%; transform:translateX(-50%);",
        "bottom-right": "bottom:20px; right:20px;"
    };

    let posStyle = positions[position] || positions["top-center"];

    let element = $(`
        <div class="custom-alert-wrapper" 
             style="position:fixed; z-index:9999; ${posStyle}">
             
            <div class="alert ${alertClass} alert-dismissible fade show text-center"
                 role="alert"
                 style="min-width:350px; padding:20px; font-size:16px;">

                <button type="button" 
                        class="btn-close" 
                        data-bs-dismiss="alert" 
                        aria-label="Close"
                        style="position:absolute; top:-15px; right:-12px; transform: scale(0.7);">
                </button>

                <strong class="me-3">${msg}</strong>

            </div>
        </div>
    `);

    $("body").append(element);

    // Auto close after 2 seconds
    setTimeout(() => {
        element.fadeOut(300, function () { $(this).remove(); });
    }, 2000);
}

function Redirect(url, delay = 0) {
    setTimeout(() => {
        window.location.href = url;
    }, delay);
}

function generatePagination(currentPage, totalPages) {

    let paginationHtml = "";

    paginationHtml += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" data-page="${currentPage - 1}">← Prev</a>
        </li>
    `;

    if (currentPage > 3) {
        paginationHtml += `
            <li class="page-item">
                <a class="page-link" data-page="1">1</a>
            </li>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        `;
    }

    for (let i = currentPage - 2; i <= currentPage + 2; i++) {
        if (i > 0 && i <= totalPages) {
            paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" data-page="${i}">${i}</a>
                </li>
            `;
        }
    }

    if (currentPage < totalPages - 2) {
        paginationHtml += `
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <li class="page-item">
                <a class="page-link" data-page="${totalPages}">${totalPages}</a>
            </li>
        `;
    }

    paginationHtml += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" data-page="${currentPage + 1}">Next →</a>
        </li>
    `;

    return paginationHtml;
}

