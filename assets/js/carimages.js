const imageContainers = document.querySelectorAll(".img_wrapper img");

let imageArray = ['../assets/images/car_1.jpg', '../assets/images/car_2.jpg', '../assets/images/car_3.jpg', '../assets/images/car_4.jpg',
    '../assets/images/car_5.jpg', '../assets/images/car_6.jpg', '../assets/images/car_7.jpg'];

function displayImages(containers, images){

containers.forEach(container => {
    // Generate a random index from 1 to images.length
    let random = Math.floor(Math.random() * images.length) + 1;

    // Access the array at (random - 1) since array indices start at 0
    container.setAttribute('src', images[random - 1]);

    console.log(`Random index: ${random}, Image: ${images[random - 1]}`);
});

}

displayImages(imageContainers, imageArray);



const imageContainersAdmin = document.querySelectorAll(".image_container .car_image");

function displayImagesAdmin(containers, images){

    containers.forEach(container => {
        // Generate a random index from 1 to images.length
        let random = Math.floor(Math.random() * images.length) + 1;

        // Access the array at (random - 1) since array indices start at 0
        container.setAttribute('src', images[random - 1]);

        console.log(`Random index: ${random}, Image: ${images[random - 1]}`);
    });

}

displayImagesAdmin(imageContainersAdmin, imageArray);

document.addEventListener('DOMContentLoaded', () => {
    const imageContainerForm = document.querySelector("main .car-container .left-part .car_image");

    const imageArray = [
        '../assets/images/car_1.jpg',
        '../assets/images/car_2.jpg',
        '../assets/images/car_3.jpg',
        '../assets/images/car_4.jpg',
        '../assets/images/car_5.jpg',
        '../assets/images/car_6.jpg',
        '../assets/images/car_7.jpg'
    ];

    function displaySingleImage(container, images) {
        // Generate a random index
        let random = Math.floor(Math.random() * images.length) + 1;

        // Set the random image to the container's src
        container.setAttribute('src', images[random]);

        console.log(`Random index: ${random}, Image: ${images[random]}`);
    }

    // Ensure the element exists before using it
    if (imageContainerForm) {
        displaySingleImage(imageContainerForm, imageArray);
    } else {
        console.error("Image container not found!");
    }
});
