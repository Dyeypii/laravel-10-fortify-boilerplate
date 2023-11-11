import axios from "axios";

const registerForm = <HTMLFormElement>document.getElementById("registerForm");

registerForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(registerForm);

    axios.post(registerForm.action, formData)
        .then(function (res) {
            console.log(res.data.data);
            window.location.href = res.data.data.redirect_url;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err.response);
            // Handle the error as needed
        });
});
