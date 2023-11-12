import axios from "axios";

const updatePasswordForm = <HTMLFormElement>document.getElementById("updatePasswordForm");

updatePasswordForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(updatePasswordForm);

    axios.post(updatePasswordForm.action, formData)
        .then(function (res) {
            console.log(res);
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
});
