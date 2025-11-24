<?php
$rules = [
    'name' => 'required|name|min:3|max:40',
    'email' => 'required|email',
    'mobile' => 'required|mobile',
    'username' => 'required|username',
    'password' => 'required|min:6|password_strong',
    'confirm_password' => 'required|match:password',
    'pincode' => 'digits:6',
    'dob' => 'date',
    'age' => 'numeric|min_value:1|max_value:120'
];

$errors = validate($_POST, $rules);

if (!empty($errors)) {
    print_r($errors);
}
?>

<script>
    $("#registerForm").on("submit", function(e) {
    e.preventDefault();

    let rules = {
        name: "required|name|min:3",
        email: "required|email",
        mobile: "required|mobile",
        password: "required|password_strong|min:6",
        confirm_password: "required|match:password",
    };

    let errors = validateForm("#registerForm", rules);

    if (Object.keys(errors).length > 0) {
        console.log(errors);
        alert("Validation failed");
        return false;
    }

    alert("Form is valid!");
});


</script>