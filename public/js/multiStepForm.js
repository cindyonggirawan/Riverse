// document.addEventListener("DOMContentLoaded", function () {
//     let currentRegisStep = 2;

//     // Function to increment the step
//     function incrementStep() {
//         currentRegisStep++;
//         updateStepText();
//     }

//     // Function to decrement the step
//     function decrementStep() {
//         currentRegisStep--;
//         updateStepText();
//     }

//     // Function to update the step text on the buttons
//     function updateStepText() {
//         // Assuming you have elements with the class 'btn-fill' and 'no-style-btn'
//         document.querySelector(
//             ".btn-fill"
//         ).innerText = `Lanjut (${currentRegisStep})`;
//         document.querySelector(".no-style-btn").innerText = `Sebelumnya (${
//             currentRegisStep - 1
//         })`;
//     }

//     // Attach click event listeners to the buttons
//     document
//         .querySelector(".btn-fill")
//         .addEventListener("click", incrementStep);
//     document
//         .querySelector(".no-style-btn")
//         .addEventListener("click", decrementStep);

//     // Initial update of step text
//     updateStepText();
// });
