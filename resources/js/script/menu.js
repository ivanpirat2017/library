
export function menu() {
    const next = document.getElementById('menu_next')
    const menu_item = document.querySelectorAll('.menu_item')
    const menuItem = document.querySelector('.header_menu')
    next.classList.toggle('menu_next_active')
        menuItem.classList.toggle('clicmenu')
    next.addEventListener('click', () => {
        next.classList.toggle('menu_next_active')
        menuItem.classList.toggle('clicmenu')
    })
    menu_item.forEach(item=>{
        item.addEventListener('click', () => {
            next.classList.toggle('menu_next_active')
            menuItem.classList.toggle('clicmenu')
        })
    })
};
