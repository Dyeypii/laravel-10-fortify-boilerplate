import axios from "axios";

const forgotPasswordForm = <HTMLFormElement>document.getElementById("forgotPasswordForm");

forgotPasswordForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(forgotPasswordForm);

    axios.post(forgotPasswordForm.action, formData)
        .then(function (res) {
            console.log(res);
            // window.location.href = res.data.data.redirect_url;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
});
