export function slider() {
    const sliderItemsAll = document.querySelector('.slider_items_all');
    const slider = document.querySelector('.slider');
    let clicon = false;
    let cursorx = 0
    let clicX = 0
    slider.addEventListener('pointerdown', (e) => {
        e.preventDefault();
        clicon = true
        clicX = e.pageX
        cursorx = +sliderItemsAll.style.left.replace('px', ' ');
    })
    slider.addEventListener('touchmove', (e) => {
        if (clicon) {
            let width = +sliderItemsAll.offsetWidth - slider.offsetWidth
            let sled = cursorx + e.changedTouches[0].pageX - clicX;
            if (-sled > 0 && width > -sled) {
                sliderItemsAll.style.left = `${cursorx + e.changedTouches[0].pageX - clicX}px`
            }
        }
    })
    slider.addEventListener('pointermove', (e) => {
        if (clicon) {
            let width = +sliderItemsAll.offsetWidth - slider.offsetWidth
            let sled = cursorx + e.pageX - clicX;
            if (-sled > 0 && width > -sled) {
                sliderItemsAll.style.left = `${cursorx + e.pageX - clicX}px`
            }
        }
    })
    window.addEventListener('pointerup', () => {
        clicon = false
    })
}
