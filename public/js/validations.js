var fullNameInput = document.getElementById("FullName");
var nameInput = document.getElementById("signUpName");
var emailInput = document.getElementById("signUpEmail");
var passwordInput = document.getElementById("signUpPassword");
var rePasswordInput = document.getElementById("signUpRePassword");
var addressInput = document.getElementById("address");  // address input
var phoneInput = document.getElementById("phone");     //phone input
var phoneAlert = document.getElementById("phoneAlert");  // phone alert
var whatsappInput = document.getElementById("whatsapp");     //whatsAPP input
var whatsappAlert = document.getElementById("whatsappAlert");  //whatsAPP alert
var fullNameAlert = document.getElementById("FullNameAlert");
var nameAlert = document.getElementById("nameAlert");
var emailAlert = document.getElementById("emailAlert");
var passwordAlert = document.getElementById("passwordAlert");
var repasswordAlert = document.getElementById("repasswordAlert");
var btn = document.getElementById("signUpButton");
var userImage = document.getElementById("userImage");
var userImageAlart = document.getElementById("userImageAlert");

var regexFullName = /^[a-zA-Z\s]{3,}$/; // Full Name:
var regexUserName = /^[a-zA-Z0-9]{3,}$/; // Username:
var regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var regexPassword = /^(?=.*\d)(?=.*[\W_])(?=.*[a-zA-Z]).{8,}$/; // Password:
var regexPhone = /^[0-9]{10,15}$/;  // Phone

// image upload validation
var isImageUploaded = userImage.files.length > 0;


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
        userImageAlart.classList.remove("d-none");
    } else {
        userImageAlart.classList.add("d-none");
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

    try {
        // Wait for the WhatsApp check to complete
        await checkWhatsAppAsync(apiKeys);

        if (window.whatsappApiResponse === "not valid") {
            whatsappInput.classList.add("is-invalid");
            whatsappInput.classList.remove("is-valid");
            whatsappAlert.innerHTML = "This is not a valid WhatsApp number.";
            whatsappAlert.classList.remove("d-none");
        } else if (window.whatsappApiResponse === "valid") {
            whatsappAlert.classList.add("d-none");
            whatsappInput.classList.remove("is-invalid");
            whatsappInput.classList.add("is-valid");

            // Proceed with form submission
            let formData = new FormData(this);
            formData.append("action", "register");

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "controllers/UserController.php", true);
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
        }
    } catch (error) {
        console.error("Error during WhatsApp validation:", error);
        alert("An error occurred while validating the WhatsApp number. Please try again.");
    }
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
