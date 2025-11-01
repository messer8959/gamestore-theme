// Dark mode style

let styleMode = localStorage.getItem('styleMode');
const styleToggle = document.querySelector('.header-mode-switcher');
if (styleToggle) {
    styleToggle.addEventListener('click', () => {
        styleMode = localStorage.getItem('styleMode');
        if (styleMode === 'dark') {
            disableDarkStyle();
        } else {
            enebleDarkStyle();
        }
    });
}

const enebleDarkStyle = () => {
    document.body.classList.add('dark-mode-gamestore');
    localStorage.setItem('styleMode', 'dark');
}
const disableDarkStyle = () => {
    document.body.classList.remove('dark-mode-gamestore');
    localStorage.setItem('styleMode', 'light');
}
if (styleMode === 'dark') {
    enebleDarkStyle();
} 
