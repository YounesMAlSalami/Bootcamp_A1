function showCookies() {
    const output = document.getElementById('cookie-output');
    output.textContent = document.cookie || 'No JavaScript-readable cookies found.';
}
document.addEventListener('DOMContentLoaded', () => {
    showCookies();
    document.getElementById('refresh-cookies').addEventListener('click', showCookies);
});
