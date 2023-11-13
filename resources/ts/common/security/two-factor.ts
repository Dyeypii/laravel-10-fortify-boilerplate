import axios from "axios";

const enableDisableTwoFactorForm = <HTMLFormElement>(
    document.getElementById("enableDisableTwoFactorForm")
);
const enableDisableTwoFactorFormAction = enableDisableTwoFactorForm.action;

enableDisableTwoFactorForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(enableDisableTwoFactorForm);

    axios
        .post(enableDisableTwoFactorFormAction, formData)
        .then(function (res) {
            console.log(res);
            window.location.href = res.data.data.redirectUrl;
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            if (err.response.data.data?.redirectUrl) {
                window.location.href = err.response.data.data.redirectUrl;
            }

            // Handle the error as needed
        });
});

const confirmTwoFactorForm = <HTMLFormElement>(
    document.getElementById("confirmTwoFactorForm")
);

confirmTwoFactorForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(confirmTwoFactorForm);

    axios
        .post(confirmTwoFactorForm.action, formData)
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

const regenerateRecoveryCodesForm = <HTMLFormElement>(
    document.getElementById("regenerateRecoveryCodesForm")
);

regenerateRecoveryCodesForm?.addEventListener("submit", function (e) {
    e.preventDefault();
    axios
        .post(regenerateRecoveryCodesForm.action)
        .then(function (res) {
            console.log(res);
            const recoveryCodesDiv = <HTMLElement>(
                document.getElementById("recoveryCodesDiv")
            );

            const recoveryCodes = res.data.data.recoveryCodes.map(
                (code: string) => {
                    return `<span>${code}</span></br>`;
                }
            );

            recoveryCodesDiv.innerHTML =
                `<p>
                Please store these recovery codes in a secure location.
            </p>` + recoveryCodes.join("");
            // Handle the response as needed
        })
        .catch(function (err) {
            console.error(err);
            // Handle the error as needed
        });
});
