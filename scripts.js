function toggleShowPassword() {
    const checkbox = document.getElementById("password");
    checkbox.type = checkbox.type === "password" ? "text" : "password";
}
