const imageInput = document.getElementById("imageInput");
const imagePreview = document.getElementById("imagePreview");
const previewImage = document.getElementById("previewImage");

imageInput.addEventListener("change", function (e) {
    const file = e.target.files[0];
    displayImage(file);
});

const dropZone = document.querySelector(".drop-zone");

dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("dragover");
});

dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("dragover");
});

dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("dragover");

    const file = e.dataTransfer.files[0];
    displayImage(file);
});

function displayImage(file) {
    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            previewImage.src = reader.result;
            imagePreview.removeAttribute("hidden");
            // Change the inner HTML of the browse-button
            document.querySelector(".browse-button").innerHTML = "Change Image";
        };
        reader.readAsDataURL(file);
    } else {
        // If there is no file, hide the image preview
        previewImage.src = "";
        imagePreview.setAttribute("hidden", true);
        // Reset the inner HTML of the browse-button to its original value
        document.querySelector(".browse-button").innerHTML = "Gambar";
    }
}
