
const imageInput = document.getElementById('image');
const imageLabel = document.getElementById('imageLabel');
const imagePreview = document.getElementById('imagePreview');
const previewContainer = document.getElementById('previewContainer');
const fileName = document.getElementById('fileName');

if(imageInput){
imageInput.addEventListener('change', function () {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block';
        };

        reader.readAsDataURL(file);

        fileName.textContent = file.name;
    } else {
        previewContainer.style.display = 'none';
        imagePreview.src = "#";
        fileName.textContent = '';
    }
});
}
if(imageLabel){
imageLabel.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default label behavior
    imageInput.click(); // Trigger file input once
});
}
