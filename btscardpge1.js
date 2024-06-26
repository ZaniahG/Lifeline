
document.getElementById('fileInput').addEventListener('change', function(event) {
    const files = event.target.files;
    const gridContainer = document.getElementById('gridContainer');

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const imageUrl = e.target.result;
            const photoBlock = document.createElement('div');
            photoBlock.classList.add('photo-block');

            const image = document.createElement('img');
            image.src = imageUrl;

            photoBlock.appendChild(image);
            gridContainer.appendChild(photoBlock);
        };

        reader.readAsDataURL(file);
    }
});