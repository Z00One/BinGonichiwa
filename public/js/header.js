const logout = (msg) => {
    const confirmed = window.confirm(msg);

    if (confirmed) {
        document.querySelector("#logout-form").submit();
    }
};

const toggleContent = () => {
    const dynamicContent = document.querySelector("#dynamicContent");
    const openIcon = document.querySelector("#openIcon");
    const closeIcon = document.querySelector("#closeIcon");

    if (dynamicContent.style.display === "none") {
        dynamicContent.style.display = "block";
        openIcon.style.display = "none";
        closeIcon.style.display = "inline-block";
    } else {
        dynamicContent.style.display = "none";
        openIcon.style.display = "inline-block";
        closeIcon.style.display = "none";
    }
};
