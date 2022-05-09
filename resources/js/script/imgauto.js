export function Imgauto(img,item) {
    return  item ? window.location.origin +'/'+ item.replace('/public', '') : img
}

