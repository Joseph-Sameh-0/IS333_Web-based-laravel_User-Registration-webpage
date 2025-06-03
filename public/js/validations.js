let fullNameInput = document.getElementById("FullName");
let nameInput = document.getElementById("signUpName");
let emailInput = document.getElementById("signUpEmail");
let passwordInput = document.getElementById("signUpPassword");
let rePasswordInput = document.getElementById("signUpRePassword");
let phoneInput = document.getElementById("phone");
let phoneAlert = document.getElementById("phoneAlert");
let whatsappInput = document.getElementById("whatsapp");
let whatsappAlert = document.getElementById("whatsappAlert");
let fullNameAlert = document.getElementById("FullNameAlert");
let nameAlert = document.getElementById("nameAlert");
let emailAlert = document.getElementById("emailAlert");
let passwordAlert = document.getElementById("passwordAlert");
let repasswordAlert = document.getElementById("repasswordAlert");
let userImage = document.getElementById("userImage");
let userImageAlert = document.getElementById("userImageAlert");

let regexFullName = /^[a-zA-Z\s]{3,}$/;
let regexUserName = /^[a-zA-Z0-9]{3,}$/;
let regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
let regexPassword = /^(?=.*\d)(?=.*[\W_])(?=.*[a-zA-Z]).{8,}$/; // Password:
let regexPhone = /^[0-9]{10,15}$/;

// image upload validation
let isImageUploaded = userImage.files.length > 0;


function Valid() {

    // Full Name validation
    if (!regexFullName.test(fullNameInput.value)) {
        fullNameInput.classList.add("is-invalid");
        fullNameAlert.classList.remove("d-none");
    } else {
        fullNameInput.classList.add("is-valid");
        fullNameInput.classList.remove("is-invalid");
        fullNameAlert.classList.add("d-none");
    }
    if (fullNameInput.value == "") {
        fullNameInput.classList.remove("is-invalid", "is-valid");
        fullNameAlert.classList.add("d-none");
    }

    // Username validation
    if (!regexUserName.test(nameInput.value)) {
        nameInput.classList.add("is-invalid");
        nameAlert.innerHTML = "Minimum 3 characters, special characters not allowed";
        nameAlert.classList.remove("d-none");
    } else {
        nameInput.classList.add("is-valid");
        nameInput.classList.remove("is-invalid");
        nameAlert.classList.add("d-none");
    }
    if (nameInput.value == "") {
        nameInput.classList.remove("is-invalid", "is-valid");
        nameAlert.classList.add("d-none");
    }

    // Email validation
    if (!regexEmail.test(emailInput.value)) {
        emailInput.classList.add("is-invalid");
        emailAlert.classList.remove("d-none");
    } else {
        emailInput.classList.add("is-valid");
        emailInput.classList.remove("is-invalid");
        emailAlert.classList.add("d-none");
    }
    if (emailInput.value == "") {
        emailInput.classList.remove("is-invalid", "is-valid");
        emailAlert.classList.add("d-none");
    }

    // Password validation
    if (!regexPassword.test(passwordInput.value)) {
        passwordInput.classList.add("is-invalid");
        passwordAlert.classList.remove("d-none");
    } else {
        passwordInput.classList.add("is-valid");
        passwordInput.classList.remove("is-invalid");
        passwordAlert.classList.add("d-none");
    }
    if (passwordInput.value == "") {
        passwordInput.classList.remove("is-invalid", "is-valid");
        passwordAlert.classList.add("d-none");
    }

    // Confirm password validation
    if (rePasswordInput.value !== "") {
        if (rePasswordInput.value !== passwordInput.value) {
            rePasswordInput.classList.add("is-invalid");
            repasswordAlert.classList.remove("d-none");
        } else {
            rePasswordInput.classList.add("is-valid");
            rePasswordInput.classList.remove("is-invalid");
            repasswordAlert.classList.add("d-none");
        }
    } else {
        rePasswordInput.classList.remove("is-invalid", "is-valid");
        repasswordAlert.classList.add("d-none");
    }


    // phone validation
    if (!regexPhone.test(phoneInput.value)) {
        phoneInput.classList.add("is-invalid");
        phoneAlert.classList.remove("d-none");
    } else {
        phoneInput.classList.add("is-valid");
        phoneInput.classList.remove("is-invalid");
        phoneAlert.classList.add("d-none");
    }
    if (phoneInput.value == "") {
        phoneInput.classList.remove("is-invalid", "is-valid");
        phoneAlert.classList.add("d-none");
    }

    // whatsapp validation
    if (!regexPhone.test(whatsappInput.value)) {
        whatsappInput.classList.add("is-invalid");
        whatsappAlert.classList.remove("d-none");
    } else {
        whatsappInput.classList.add("is-valid");
        whatsappInput.classList.remove("is-invalid");
        whatsappAlert.classList.add("d-none");
    }
    if (whatsappInput.value == "") {
        whatsappInput.classList.remove("is-invalid", "is-valid");
        whatsappAlert.classList.add("d-none");
    }

    isImageUploaded = userImage.files.length > 0;

    if (!isImageUploaded) {
        userImageAlert.classList.remove("d-none");
    } else {
        userImageAlert.classList.add("d-none");
    }
}


document.getElementById("signUpForm").addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent default form submission

    Valid();
    isImageUploaded = userImage.files.length > 0;

    // Validate inputs
    if (!(
        regexFullName.test(fullNameInput.value) &&
        regexUserName.test(nameInput.value) &&
        regexEmail.test(emailInput.value) &&
        regexPassword.test(passwordInput.value) &&
        rePasswordInput.value === passwordInput.value &&
        regexPhone.test(phoneInput.value) &&
        regexPhone.test(whatsappInput.value) &&
        isImageUploaded)
    ) {
        return;
    }


    // Proceed with form submission
    let formData = new FormData(this);
    formData.append("action", "register");

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/users/store", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            let response = JSON.parse(xhr.responseText);

            if (response.status === "error") {
                showErrors(response.errors);
            } else {
                response.message === undefined ? alert("User registered successfully") : alert(response.message);
                document.getElementById("signUpForm").reset(); // Reset form on success
            }
        }
    };
    xhr.send(formData);

});


// Display validation errors dynamically
function showErrors(errors) {
    Object.keys(errors).forEach(function (key) {
        // console.log(key);
        let alertDiv = document.getElementById(key + "Alert");
        if (alertDiv) {
            alertDiv.classList.remove("d-none");
            alertDiv.innerHTML = errors[key];
        }
    });
}
