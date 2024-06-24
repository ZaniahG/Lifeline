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