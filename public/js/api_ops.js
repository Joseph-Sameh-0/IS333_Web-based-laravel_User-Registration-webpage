window.whatsappApiResponse = null;
document.getElementById("checkWhatsApp").addEventListener("click", function (event) {
    var whatsappInput = document.getElementById("whatsapp");
    var countryCode = document.getElementById("countryCode");
    var selectedCode = countryCode.value;
    var whatsappNumber = whatsappInput.value.trim();

    var fullNumber = selectedCode + whatsappNumber;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/check-whatsapp", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ phone_number: fullNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "valid") {
            window.whatsappApiResponse = "valid";
            alert("This number has WhatsApp.");
        } else {
            window.whatsappApiResponse = "not valid";
            alert("This number is not a valid WhatsApp number.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong !");
    });
});  