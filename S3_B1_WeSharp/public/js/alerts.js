/**
 * @file alerts.js
 * JS script used to display alerts messages and hides them after a while
 * 
 * @package DE-BUT
 */

document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll(".alert");

    // Displays 3 seconds
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 600);
        }, 3000);
    });
});