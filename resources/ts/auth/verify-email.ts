import axios from "axios";

const verifyEmailForm = <HTMLFormElement>document.getElementById("verifyEmailForm");

verifyEmailForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(verifyEmailForm);

    axios.post(verifyEmailForm.action, formData)
        .then(function (res) {
            console.log(res);
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err.response);
            // Handle the error as needed
        });
});
