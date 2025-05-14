window.whatsappApiResponse = null;

const israaAPIKEY1 = "ac473eab33mshb82011782bcc4aap15c9b3jsn3a63b12de4df";
const israaAPIKEY2 = "7934d542a9msh1d255f41af26346p13e040jsn517da03aedf4";
const josephAPIKEY1 = "a6a34bf089mshda317112704a8adp1cd899jsnea75dc0992e4";
const amanyAPIKEY1 = "bd4af4fed3msh5cce71bee29321bp143febjsn8784978f97b7";
const nourAPIKEY1 = "78718d2a7dmsh7dcfbae259c0f70p1df2dfjsndeea78167fcf";
const israaAPIKEY3 = "2dcec1e78bmsh0528a4942ec9f47p164759jsn8702f3508936";
const israaAPIKEY4 = "af6cb4360amsh9d91a988e4f7df2p11513djsn844b31521070";
const israaAPIKEY5 = "f3f7834093mshfff0341a646e910p114b1cjsnb3709cf7e570";

apiKeys = [israaAPIKEY1, josephAPIKEY1, israaAPIKEY2, amanyAPIKEY1, nourAPIKEY1, israaAPIKEY3, israaAPIKEY4, israaAPIKEY5];

function checkWhatsApp(apiKeys, currentKeyIndex = 0) {
    // If no more API keys are available, stop and alert the user
    if (currentKeyIndex >= apiKeys.length) {
        alert("All API keys have been exhausted. Please try again later.");
        return;
    }

    var whatsappInput = document.getElementById("whatsapp");
    var countryCode = document.getElementById("countryCode");
    var selectedCode = countryCode.value;
    var whatsappNumber = whatsappInput.value.trim();

    var fullNumber = selectedCode + whatsappNumber;

    fetch("https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-RapidAPI-Key": apiKeys[currentKeyIndex],
            "X-RapidAPI-Host": "whatsapp-number-validator3.p.rapidapi.com"
        },
        body: JSON.stringify({phone_number: fullNumber})
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("API request failed");
            }
            return response.json();
        })
        .then(data => {
            if (data.status === "valid") {
                window.whatsappApiResponse = "valid";
                alert("This number has WhatsApp.");
            } else {
                window.whatsappApiResponse = "not valid";
                alert("This number is not a valid WhatsApp number. Please enter a valid WhatsApp number.");
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);

            // Retry with the next API key
            if (currentKeyIndex < apiKeys.length - 1) {
                console.log("Retrying with the next API key...");
                checkWhatsApp(apiKeys, currentKeyIndex + 1);
            } else {
                alert("All API keys have been exhausted. Please try again later.");
            }
        });
}

document.getElementById("checkWhatsApp").addEventListener("click", function (event) {
    checkWhatsApp(apiKeys);
});


function checkWhatsAppAsync(apiKeys, currentKeyIndex = 0) {
    return new Promise((resolve, reject) => {
        if (currentKeyIndex >= apiKeys.length) {
            reject(new Error("All API keys have been exhausted."));
            return;
        }

        var whatsappInput = document.getElementById("whatsapp");
        var countryCode = document.getElementById("countryCode");
        var selectedCode = countryCode.value;
        var whatsappNumber = whatsappInput.value.trim();

        var fullNumber = selectedCode + whatsappNumber;

        fetch("https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-RapidAPI-Key": apiKeys[currentKeyIndex],
                "X-RapidAPI-Host": "whatsapp-number-validator3.p.rapidapi.com"
            },
            body: JSON.stringify({phone_number: fullNumber})
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("API request failed");
                }
                return response.json();
            })
            .then(data => {
                if (data.status === "valid") {
                    window.whatsappApiResponse = "valid";
                    resolve();
                } else {
                    window.whatsappApiResponse = "not valid";
                    resolve();
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);

                // Retry with the next API key
                if (currentKeyIndex < apiKeys.length - 1) {
                    console.log("Retrying with the next API key...");
                    checkWhatsAppAsync(apiKeys, currentKeyIndex + 1).then(resolve).catch(reject);
                } else {
                    reject(new Error("All API keys have been exhausted."));
                }
            });
    });
}