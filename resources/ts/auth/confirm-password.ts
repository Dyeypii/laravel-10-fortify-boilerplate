import axios from "axios";

const confirmPasswordForm = <HTMLFormElement>document.getElementById("confirmPasswordForm");
const urlIntended = document.referrer;
confirmPasswordForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(confirmPasswordForm);

    axios.post(confirmPasswordForm.action, formData)
        .then(function (res) {
            console.log(res);
            window.location.href = res.data.data.redirectUrl ?? urlIntended;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
});
