const password = document.getElementById("password-input");
const eye = document.getElementById("password-addon");
const confirmPassword = document.getElementById("confirm-password-input");
const confirmEye = document.getElementById("confirm-password-addon");

eye.addEventListener("click", () => {
    password.type = password.type === "password" ? "text" : "password";
    eye.querySelector("i").classList.toggle("fa-eye-fill");
});

confirmEye.addEventListener("click", () => {
    confirmPassword.type = confirmPassword.type === "password" ? "text" : "password";
    confirmEye.querySelector("i").classList.toggle("fa-eye-fill");
});