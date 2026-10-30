function toggleFav(btn, toolId) {
    fetch("add_favorite.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "tool_id=" + toolId
    })
    .then(res => res.text())
    .then(data => {
        let toast = document.getElementById("toast");
        // remove extra whitespace from response
        let result = data.trim(); 
        
        if (result === "added") {
            btn.innerHTML = "❤️";
            toast.innerHTML = "Added to Favorites ❤️";
        } else {
            btn.innerHTML = "🤍";
            toast.innerHTML = "Removed from Favorites 💔";
        }
        toast.style.display = "block";
        setTimeout(() => toast.style.display = "none", 2000);
    });
}