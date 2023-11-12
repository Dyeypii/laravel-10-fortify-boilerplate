import axios from "axios";

const resetPasswordForm = <HTMLFormElement>document.getElementById("resetPasswordForm");

resetPasswordForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(resetPasswordForm);

    axios.post(resetPasswordForm.action, formData)
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
