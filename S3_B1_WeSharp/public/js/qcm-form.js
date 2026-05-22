/**
 * @file qcm-form.js
 * JS script used for the creation of a new QCM
 * 
 * It allows us to create a new question or to delete one easily.
 * 
 * @package DE-BUT
 */

document.addEventListener("DOMContentLoaded", () => {

    let questionIndex = 1;
    const container = document.getElementById('questions-container');
    const addBtn = document.getElementById('add-question');

    if (!container || !addBtn) return;

    // Adds a new question
    addBtn.addEventListener('click', function () {
        const template = container.firstElementChild.cloneNode(true);
        template.setAttribute('data-index', questionIndex);

        // Resets the fields
        // input name = the index of the question
        // input value = empty
        // checkbox = unchecked
        template.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\d+/, questionIndex);
            input.value = "";
            if (input.type === "checkbox") input.checked = false;
        });

        container.appendChild(template);
        questionIndex++;
    });

    // Deletes a question
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-question')) {
            const blocks = document.querySelectorAll('.question-block');
            if (blocks.length > 1) {
                e.target.closest('.question-block').remove();
            } else {
                alert("Il doit rester au moins une question.");
            }
        }
    });

});