

function enableEdit(transactionId) {
    const transactionText = document.getElementById("transactionText_" + transactionId);
    const transactionWrap = transactionText.parentElement;
    const editButton = transactionWrap.querySelector(".btn-outline-primary");
    const form = transactionWrap.querySelector(".update-form");
    form.classList.toggle("hidden");
    editButton.classList.toggle("hidden");
}


const editButtons = document.querySelectorAll(".btn-outline-primary");
console.log(editButtons);
editButtons.forEach((button) => {
    button.addEventListener("click", e => {
        const div = document.querySelector(`div.d-none`)
        div.classList
        const id = e.target.dataset.id;
        const name = time.querySelector(`[data-text-id="${id}"]`).innerText;
        const transactionId = this.getAttribute("data-id");
        createForm(id, name);
    });
});



function createForm(id, name) {
    const form = document.querySelector("#renameFormTemplate").content.cloneNode(true);

    form.querySelector('[name="choiceText"]').value = name;
    form.querySelector('[name="idChoice"]').value = id;
    form.querySelector('form').dataset.formId = id;
    
    return form.querySelector('form');
}
