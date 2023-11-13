import axios from "axios";

const twoFactorLoginForm = <HTMLFormElement>document.getElementById("twoFactorLoginForm");

twoFactorLoginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(twoFactorLoginForm);

    axios.post(twoFactorLoginForm.action, formData)
        .then(function (res) {
            console.log(res);
            window.location.href = res.data.data.redirectUrl;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
});
