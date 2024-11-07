const menuBtn = document.querySelector('#menuBtn');
const hamburgerIcon = document.querySelector('#hamburgerBars');
const nav = document.querySelector('#navItemsContainer');
const menuText = document.querySelector('#menuBtn p');

menuBtn.addEventListener('click', () => {

    nav.classList.toggle('is-active-nav');
    hamburgerIcon.classList.toggle('active');
    menuBtn.classList.toggle('active');

    // Verander de tekst van "Menu" naar "Sluit" en andersom
    if (menuBtn.classList.contains('active')) {
        menuText.textContent = 'SLUIT';
    } else {
        menuText.textContent = 'MENU';
    }
});