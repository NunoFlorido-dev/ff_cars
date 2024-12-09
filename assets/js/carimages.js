// Function to set random images to one or multiple containers
function displayImages(containers, images) {
    containers.forEach(container => {
        // Generate a random index from 0 to images.length - 1
        let random = Math.floor(Math.random() * images.length);

        // Set the random image to the container's src
        container.setAttribute('src', images[random]);

        console.log(`Random index: ${random}, Image: ${images[random]}`);
    });
}

// Function to set a random image for a single container
function displaySingleImage(container, images) {
    if (!container) {
        console.error("Container not found!");
        return;
    }

    // Generate a random index
    let random = Math.floor(Math.random() * images.length);

    // Set the random image to the container's src
    container.setAttribute('src', images[random]);

    console.log(`Random index: ${random}, Image: ${images[random]}`);
}

// Main script
document.addEventListener('DOMContentLoaded', () => {
    const imageArray = [
        '../assets/images/car_1.jpg',
        '../assets/images/car_2.jpg',
        '../assets/images/car_3.jpg',
        '../assets/images/car_4.jpg',
        '../assets/images/car_5.jpg',
        '../assets/images/car_6.jpg',
        '../assets/images/car_7.jpg'
    ];

    // Select multiple image containers
    const imageContainers = document.querySelectorAll(".img_wrapper img");
    const imageContainersAdmin = document.querySelectorAll(".image_container .car_image");

    // Select a single image container
    const imageContainerForm = document.querySelector("main .car-container .left-part .car_image");

    // Display random images
    displayImages(imageContainers, imageArray);
    displayImages(imageContainersAdmin, imageArray);
    displaySingleImage(imageContainerForm, imageArray);
});
