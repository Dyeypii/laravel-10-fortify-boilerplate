import axios from "axios";

const logoutForm = <HTMLFormElement>document.getElementById("logoutForm");
const logoutButton = <HTMLAnchorElement | HTMLButtonElement>document.querySelector(".logout-btn");

function handleLogout(logoutForm: HTMLFormElement){
    const formData = new FormData(logoutForm);

    axios.post(logoutForm.action, formData)
        .then(function (res) {
            console.log(res.data);
            window.location.href = res.data.data.redirect_url;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
}

logoutForm?.addEventListener("submit", function (e) {
    e.preventDefault();
    handleLogout(logoutForm);
});

logoutButton?.addEventListener("click", function (e) {
    e.preventDefault();
    handleLogout(logoutForm);
});
