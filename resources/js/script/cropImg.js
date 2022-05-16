export function cropImg(url, aspectRatio ) {
    return new Promise(resolve => {
        const inputImage = new Image();
        inputImage.onload = () => {
            const outputImage = document.createElement('canvas');
            outputImage.width = inputImage.naturalWidth;
            outputImage.height = inputImage.naturalHeight;
            const ctx = outputImage.getContext('2d');
            ctx.drawImage(inputImage, inputImage.naturalWidth, inputImage.naturalHeight);
            resolve(outputImage.toDataURL(url));
        };
       inputImage.src = url;

    })

}
