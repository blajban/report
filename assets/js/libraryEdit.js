function enableSaveButton(inputElement) {
    const form = inputElement.closest('form');
    const saveButton = form.querySelector('.save-button');
    saveButton.disabled = false;
    saveButton.classList.remove('save-button');
}

const inputFields = document.querySelectorAll('input[type="input"], input[type="file"]');
inputFields.forEach(input => {
    input.addEventListener('change', () => enableSaveButton(input));
});