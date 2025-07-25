// script.js

// Ensure the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {

    // 1. Dynamic Semester Options Based on Selected Year
    const yearSelect = document.getElementById('year');
    const semSelect = document.getElementById('sem');

    yearSelect.addEventListener('change', function() {
        const year = this.value;
        semSelect.innerHTML = '<option value="" disabled selected hidden>Select Semester</option>'; // Reset semesters

        let semesters = [];

        switch(year) {
            case 'I':
                semesters = ['01', '02'];
                break;
            case 'II':
                semesters = ['03', '04'];
                break;
            case 'III':
                semesters = ['05', '06'];
                break;
            case 'IV':
                semesters = ['07', '08'];
                break;
            default:
                semesters = [];
        }

        semesters.forEach(function(sem) {
            const option = document.createElement('option');
            option.value = sem;
            option.text = sem;
            semSelect.appendChild(option);
        });
    });

    // 2. Validate Form Fields Before Creating the Table
    const addButton = document.getElementById('add_button');
    const formError = document.getElementById('form-error');
    const submitButton = document.getElementById('Submit_button');

    addButton.addEventListener('click', function() {
        const degree = document.getElementById('degree').value;
        const branch = document.getElementById('branch').value;
        const year = document.getElementById('year').value;
        const regulation = document.getElementById('regulation').value;
        const sem = document.getElementById('sem').value;
        const numSubjects = document.getElementById('num_subjects').value;

        // Check if all required fields are filled
        if (!degree || !branch || !year || !regulation || !sem || !numSubjects) {
            formError.style.display = 'block';
            formError.textContent = 'Please fill in all the details before adding subjects.';
            return;
        } else {
            formError.style.display = 'none';
        }

        // Proceed to create or update the table
        const parsedNumSubjects = parseInt(numSubjects, 10);
        const tableBody = document.getElementById('subjects_table').getElementsByTagName('tbody')[0];
        const currentRows = tableBody.getElementsByTagName('tr').length;

        if (parsedNumSubjects > currentRows) {
            for (let i = currentRows; i < parsedNumSubjects; i++) {
                const row = tableBody.insertRow();

                // Insert cells
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                const cell3 = row.insertCell(2);
                const cell4 = row.insertCell(3);
                const cell5 = row.insertCell(4);
                const cell6 = row.insertCell(5); // Delete column

                // Insert input fields
                cell1.innerHTML = `
                    <select name="courseCategory[]" required>
                        <option value="" disabled selected hidden>Select Category</option>
                        <option value="PEC">PEC</option>
                        <option value="HSMC">HSMC</option>
                        <option value="BSC">BSC</option>
                        <option value="ESC">ESC</option>
                        <option value="EEC">EEC</option>
                        <option value="PCC">PCC</option>
                        <option value="MC">MC</option>
                        <option value="OEC">OEC</option>
                    </select>
                `;
                cell2.innerHTML = `
                    <select name="courseType[]" required>
                        <option value="" disabled selected hidden>Select Type</option>
                        <option value="Theory">Theory</option>
                        <option value="Practical">Practical</option>
                        <option value="Theory cum Practical">Theory cum Practical</option>
                    </select>
                `;
                cell3.innerHTML = '<input type="text" placeholder="Enter Subject Code" name="subjectCode[]" required>';
                cell4.innerHTML = '<input type="text" placeholder="Enter Subject Name" name="subjectName[]" required>';
                cell5.innerHTML = '<input type="number" placeholder="Enter Credit Points" min="0" step="1" name="creditPoints[]" required>';

                // Insert Delete button with dustbin icon using Font Awesome
                cell6.innerHTML = `
                    <button type="button" class="delete-button" aria-label="Delete Subject">
                        <i class="fas fa-trash-alt" style="color: #ff0000;"></i>
                    </button>
                `;
            }
        } else if (parsedNumSubjects < currentRows) {
            for (let i = currentRows; i > parsedNumSubjects; i--) {
                tableBody.deleteRow(-1);
            }
        }

        // Show the Submit button if there are rows in the table
        if (tableBody.getElementsByTagName('tr').length > 0) {
            submitButton.style.display = 'block';
        } else {
            submitButton.style.display = 'none';
        }
    });

    // 3. Delete Functionality for Dynamically Added Rows
    const subjectsTable = document.getElementById('subjects_table');

    subjectsTable.addEventListener('click', function(event) {
        if (event.target && event.target.matches('i.fas.fa-trash-alt')) {
            const row = event.target.closest('tr');
            if (row) {
                row.remove();
            }

            // Hide the Submit button if no rows are left
            const tableBody = subjectsTable.getElementsByTagName('tbody')[0];
            if (tableBody.getElementsByTagName('tr').length === 0) {
                submitButton.style.display = 'none';
            }
        }
    });

    // 4. Validate the Form on Submit to Ensure No Empty Fields
    const form = document.getElementById('subjectform');

    form.addEventListener('submit', function(event) {
        // Prevent form submission to perform validation
        event.preventDefault();

        const courseCategories = document.getElementsByName('courseCategory[]');
        const courseTypes = document.getElementsByName('courseType[]');
        const subjectCodes = document.getElementsByName('subjectCode[]');
        const subjectNames = document.getElementsByName('subjectName[]');
        const creditPoints = document.getElementsByName('creditPoints[]');

        let allFieldsFilled = true;
        let firstInvalidRow = null;

        for (let i = 0; i < courseCategories.length; i++) {
            if (
                !courseCategories[i].value ||
                !courseTypes[i].value ||
                !subjectCodes[i].value.trim() ||
                !subjectNames[i].value.trim() ||
                !creditPoints[i].value.trim()
            ) {
                allFieldsFilled = false;
                firstInvalidRow = i + 1; // For user-friendly numbering
                break;
            }
        }

        if (!allFieldsFilled) {
            alert(`Please fill in all the fields for each subject. Error found in row ${firstInvalidRow}.`);
            return false;
        }

        // If validation passes, submit the form
        form.submit();
    });

});
