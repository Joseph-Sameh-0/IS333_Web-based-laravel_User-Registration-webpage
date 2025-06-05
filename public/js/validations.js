let fullNameInput = document.getElementById("FullName");
let nameInput = document.getElementById("signUpName");
let emailInput = document.getElementById("signUpEmail");
let passwordInput = document.getElementById("signUpPassword");
let rePasswordInput = document.getElementById("signUpRePassword");
let phoneInput = document.getElementById("phone");
let phoneAlert = document.getElementById("phoneAlert");
let countryCode = document.getElementById("countryCode");
let whatsappInput = document.getElementById("whatsapp");
let whatsappAlert = document.getElementById("whatsup_numberAlert");
let fullNameAlert = document.getElementById("full_nameAlert");
let nameAlert = document.getElementById("user_nameAlert");
let emailAlert = document.getElementById("emailAlert");
let passwordAlert = document.getElementById("passwordAlert");
let repasswordAlert = document.getElementById("confirm_passwordAlert");
let userImage = document.getElementById("userImage");
let userImageAlert = document.getElementById("student_imgAlert");

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

    if (rePasswordInput) {    // Confirm password validation
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

    if (userImageAlert) {
        if (!isImageUploaded) {
            userImageAlert.classList.remove("d-none");
        } else {
            userImageAlert.classList.add("d-none");
        }
    }

    document.getElementById("whatsappPreview").textContent = "Full WhatsApp: " + (countryCode.value + whatsappInput.value);
}


let signupForm = document.getElementById("signUpForm")
if (signupForm) {
    signupForm.addEventListener("submit", async function (event) {
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

        // Create a new FormData object with correct keys
        const transformedData = new FormData();

        // Map form fields to Laravel expected keys
        transformedData.append('full_name', formData.get('FullName'));
        transformedData.append('user_name', formData.get('signUpName'));
        transformedData.append('phone', formData.get('phone'));
        transformedData.append('whatsup_number', formData.get('whatsappCountryCode') + formData.get('whatsapp'));
        transformedData.append('address', formData.get('address'));
        transformedData.append('email', formData.get('signUpEmail'));
        transformedData.append('password', formData.get('signUpPassword'));
        transformedData.append('confirm_password', formData.get('signUpRePassword'));

        const imageFile = formData.get('userImage');
        if (imageFile && imageFile.size > 0) {
            transformedData.append('student_img', imageFile);
        }

        // Append CSRF token manually or use meta tag
        transformedData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        transformedData.append("action", "register");

        console.log("Transformed form data:", Object.fromEntries(transformedData));

        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        fetch("/users/store", {
            method: "POST",
            headers: headers,
            body: transformedData
        })
            .then(response => {

                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(JSON.stringify(errorData));
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log(data);

                if (data.status === "error") {
                    showErrors(data.errors);
                } else {
                    data.message === undefined ? alert("User registered successfully") : alert(data.message);
                    signupForm.reset();
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                }
            })
            .catch(error => {
                console.error("Error:", error.message);
                try {
                    const errorDetails = JSON.parse(error.message);

                    if (errorDetails.errors) {
                        showErrors(errorDetails.errors);
                    } else {
                        alert("Error: " + error.message);
                    }
                } catch (e) {
                    alert("Error: " + error.message);
                }
            });

    });
}

let editForm = document.getElementById("editForm");
if (editForm) {
    editForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission

        Valid();

        // Validate inputs
        if (!(
            regexFullName.test(fullNameInput.value) &&
            regexUserName.test(nameInput.value) &&
            regexEmail.test(emailInput.value) &&
            regexPhone.test(phoneInput.value) &&
            regexPhone.test(whatsappInput.value))
        ) {
            return;
        }


        // Proceed with form submission
        let formData = new FormData(this);

        // Create a new FormData object with correct keys
        const transformedData = new FormData();

        // Map form fields to Laravel expected keys
        transformedData.append('full_name', formData.get('FullName'));
        transformedData.append('user_name', formData.get('signUpName'));
        transformedData.append('phone', formData.get('phone'));
        transformedData.append('whatsup_number', formData.get('whatsappCountryCode') + formData.get('whatsapp'));
        transformedData.append('address', formData.get('address'));
        transformedData.append('email', formData.get('signUpEmail'));
        transformedData.append('password', formData.get('signUpPassword'));

        const imageFile = formData.get('userImage');
        if (imageFile && imageFile.size > 0) {
            transformedData.append('student_img', imageFile);
        }

        // Append CSRF token manually or use meta tag
        transformedData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        transformedData.append("action", "register");

        console.log("Transformed form data:", Object.fromEntries(transformedData));

        fakeFormData = new FormData();
        fakeFormData.append('full_name', "Joseph");
        fakeFormData.append('user_name', "Joseph");

        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            // 'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        const userId = editForm.getAttribute('UserId');
        const url = `/users/${userId}`;

        console.log("Sending PUT request to:", url);
        console.log(Object.fromEntries(transformedData));

        fetch(url, {
            method: "PUT",
            headers: headers,
            body: fakeFormData
        })
            .then(response => {

                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(JSON.stringify(errorData));
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log(data);

                if (data.status === "error") {
                    showErrors(data.errors);
                } else {
                    data.message === undefined ? alert("User edited successfully") : alert(data.message);
                    editForm.reset();
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                }
            })
            .catch(error => {
                console.error("Error:", error.message);
                try {
                    const errorDetails = JSON.parse(error.message);

                    if (errorDetails.errors) {
                        showErrors(errorDetails.errors);
                    } else {
                        alert("Error: " + error.message);
                    }
                } catch (e) {
                    alert("Error: " + error.message);
                }
            });

    });
}

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
