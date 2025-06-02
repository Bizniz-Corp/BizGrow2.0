const nav = document.querySelector('.component-sidebar');
const body = document.querySelector('body');
const mainContent = document.querySelector('.main');


fetch('../../components/sidebar.html')
    .then(res => res.text())
    .then(data => {
        nav.innerHTML = data;

        const hamBurger = document.querySelector('.toggle-btn');
        hamBurger.addEventListener('click', function () {
            document.querySelector('#sidebar').classList.toggle('expand');
            document.body.classList.toggle('sidebar-loaded');
            updateMainMargin();
        });
    });

function updateMainMargin() {
    if (body.classList.contains('sidebar-loaded')) {
        mainContent.style.marginLeft = '16.25rem';  
    } else {
        mainContent.style.marginLeft = '4.375rem';  
    }
}

updateMainMargin();

window.addEventListener('resize', updateMainMargin);
