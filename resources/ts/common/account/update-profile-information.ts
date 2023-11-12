import axios from "axios";

const updateProfileInformationForm = <HTMLFormElement>document.getElementById("updateProfileInformationForm");

updateProfileInformationForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(updateProfileInformationForm);

    axios.post(updateProfileInformationForm.action, formData)
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
