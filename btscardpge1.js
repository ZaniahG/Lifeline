
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
document.querySelectorAll('.select-image').forEach((button, index) => {
    button.addEventListener('click', function() {
        const input = button.nextElementSibling; // Assumes the input is right after the button
        input.click();
    });
});

document.querySelectorAll('.imageUpload').forEach((input, index) => {
    input.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgArea = input.parentElement.querySelector('.img-area');
                imgArea.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image" style="max-width: 100%; height: auto;">`;
            }
            reader.readAsDataURL(file);
        }
    });
});

document.querySelectorAll('.imageUpload').forEach((input, index) => {
    input.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('image', file);

            fetch('/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const imgArea = input.parentElement.querySelector('.img-area');
                    imgArea.innerHTML = `<img src="${data.filePath}" alt="Uploaded Image" style="max-width: 100%; height: auto;">`;
                } else {
                    console.error('Error uploading image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});