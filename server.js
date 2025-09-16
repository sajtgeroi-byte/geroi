async function loginUser(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const response = await fetch('login.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.text();
    console.log('Response status:', response.status);
    console.log('Response text:', result);
    alert(result);

    if (response.ok) {
        closeLoginModal();
        document.getElementById('user-info').innerText = `Вітаємо, ${formData.get('username')}!`;
        document.getElementById('logout').style.display = 'block';
    } else {
        alert('Невірне ім\'я користувача або пароль. Будь ласка, спробуйте ще раз.');
    }
}
function toggleMenu() {
    const navMenu = document.querySelector('.nav-menu');
    navMenu.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', () => {
    // Закриття меню при натисканні на пункт меню
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.classList.remove('active'); // Закриваємо меню
        });
    });
});







