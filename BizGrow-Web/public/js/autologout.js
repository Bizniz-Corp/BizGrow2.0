(function () {
    let timeout = 30 * 1000; // 30 detik
    let timer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(autoLogout, timeout);
    }

    function autoLogout() {
        console.log("Auto logout dipicu");

        // Kirim request logout ke server (jika butuh)
        fetch('/api/logout', {
            method: 'POST',
            headers: {
                Authorization: localStorage.getItem("Authorization"),
                Accept: "application/json",
                "Content-Type": "application/json"
            }
        }).finally(() => {
            localStorage.removeItem("Authorization");
            localStorage.removeItem("token");
            alert("Anda telah logout karena tidak aktif selama 30 detik.");
            window.location.href = "/login";
        });
    }

    // Trigger saat aktivitas terdeteksi
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
})();
