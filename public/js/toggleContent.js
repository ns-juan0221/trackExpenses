function toggleView() {
    const desktop = document.getElementById("desktopContent");
    const mobile = document.getElementById("mobileContent");

    if (!desktop || !mobile) return;

    if (window.innerWidth <= 500) {
        // フォーカスを強制的に body に戻す（エラー回避）
        if (document.activeElement && desktop.contains(document.activeElement)) {
            document.body.focus(); 
        }

        desktop.style.display = "none";
        desktop.setAttribute("inert", "true");
        mobile.style.display = "block";
        mobile.removeAttribute("inert");
    } else {
        // フォーカスを強制的に body に戻す（エラー回避）
        if (document.activeElement && desktop.contains(document.activeElement)) {
            document.body.focus(); 
        }

        desktop.style.display = "block";
        desktop.removeAttribute("inert");
        mobile.style.display = "none";
        mobile.setAttribute("inert", "true");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    toggleView();
    window.addEventListener("resize", toggleView);
});
