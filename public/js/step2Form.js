function decrementValue() {
    const input = document.getElementById("minimumNumberOfSukarelawan");
    if (parseInt(input.value) > 0) {
        input.value = parseInt(input.value) - 1;
    }
}

function incrementValue() {
    const input = document.getElementById("minimumNumberOfSukarelawan");
    input.value = parseInt(input.value) + 1;
}
