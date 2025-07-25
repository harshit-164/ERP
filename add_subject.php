<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
        <style>
            <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            display: flex;
            flex-wrap: wrap; 
            gap: 20px; 
            justify-content: space-between; 
        }
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: left;
            color: #808080;
            width: 100%; 
            border-color: #89B0E7;
            transition: border-color 0.3s ease;
        }
        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select, 
        .form-group input {
            width: 100%;
            padding-top: 3%;
            padding-bottom: 3%;
            color: #808080;
            border: 1px solid #89B0E7;
            text-align: left;
            padding-left: 3%;
            outline: #89B0E7;
            transition: border-color 0.3s ease;
            
        }
        .form-group select:focus, 
        .form-group input:focus {
            box-shadow: 0 0 10px 2px rgba(0, 123, 255, 0.75);
            border-color: #89B0E7; 
        outline: none; 
        }
       .table-container {
            margin-top: 20px;
            overflow-x: auto;
            
        }

        table {
            width: 100%;
            border-collapse: collapse;
           
        }
        th, td {
            border-bottom: 1px solid #89B0E7;
            padding: 8px;
            text-align: left;
        }
        td input {
            width: 100%; 
            border: none;
            outline: none;
            padding: 8px;
        }
         input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        
        input[type=number] {
            -moz-appearance: textfield;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }
        #add_button, #view_button, #delete_button {
            width: 114px;                  
            height: 39px;                  
            color: white;
            background-color: #89B0E7;          
            gap: 0px;                      
            border-radius: 24px 24px 24px 24px; 
            border: 1px solid #89B0E7;     
            opacity: 1;     
        }      
        #view_button{
            margin-right: 10px; 
        }
        #Submit_button {
            width: 114px;                  
            height: 39px;                 
            position: absolute; 
            color: white;
            background-color: #89B0E7;          
            gap: 0px;                    
            border-radius: 24px 24px 24px 24px;
            border: 1px solid #89B0E7;    
            opacity: 1; 
            right:0;
            margin-right: 70px;     
        }
        #add_button:hover, #view_button:hover, #delete_button:hover, #Submit_button:hover {
            background-color: #5679B8; 
        }
        @media (max-width: 768px) {
            .form-group {
                max-width: 45%; 
            }
            table, th, td {
                font-size: 0.9em; 
            }
        }
        @media (max-width: 480px) {
            .form-group {
                max-width: 100%; 
            }
            table, th, td {
                display: block; 
                width: 100%;
            }
            th, td {
                border: none; 
                border-bottom: 1px solid #89B0E7;
                position: relative;
                padding-left: 50%; 
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }
            td input {
                width: calc(100% - 20px); 
                margin-left: 10px; 
            }
        }
    </style>
        </style>
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span>Add Subject</span>
                    </div>
                    <div class="cnt_sec">
                        <!-- white card section -->
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">
                                    Subject Module
                                </h4>
                            </div>
                            <form id="subjectform" action="subjectbe.php" method="post" onsubmit="return validateForm()" class="card_cnt">
                                <h3></h3>
                                <div>
                                    <div class="form-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-between;">
                                        <div class="form-group" style="width: 30%;">
                                            <label for="degree" style = "text-align: left;">Degree</label>
                                            <select id="degree" name="degree"> 
                                                <option value="" disabled selected hidden>Select Degree</option>
                                                <option value="B.E">B.E</option>
                                                <option value="B.Tech">B.Tech</option>
                                                <option value="MBA">MBA</option>
                                                <option value="M.E">M.E</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 30%;">
                                            <label for="branch" style = "text-align: left;">Branch</label>
                                            <select id="branch" name="branch">  
                                                <option value="" disabled selected hidden>Select Branch</option>
                                                <option value="AERO">Aeronautical Engineering</option>
                                                <option value="AIDS">Artificial Intelligence & Data Science</option>
                                                <option value="BIO">Bio Technology</option>
                                                <option value="CHEM">Chemical Engineering</option>
                                                <option value="CSE">Computer Science & Engineering</option>
                                                <option value="IT">Information Technology</option>
                                                <option value="ECE">Electrical & Communication Engineering</option>
                                                <option value="EEE">Electrical & Electronics Engineering</option>
                                                <option value="MECH">Mechanical Engineering</option>
                                                <option value="CIVIL">Civil Engineering</option>
                                                <option value="SE">Structural Engineering</option>
                                                <option value="ED">Engineering Design</option>
                                                <option value="AE">Applied Electronics</option>
                                                <option value="MBA">MBA</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 30%;">
                                            <label for="year" style = "text-align: left;">Year</label>
                                            <select id="year" name="year">                 
                                                <option value="" disabled selected hidden>Select Year</option>
                                                <option value="I">I</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                                <option value="V">V</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 30%;">
                                            <label for="regulation">Regulation</label>
                                            <select id="regulation" name="regulation" onchange="toggleCustomRegulation()">
        <option value="" disabled selected hidden>Select Regulation</option>
        <option value="2021">2021</option>
        <option value="2025">2025</option>
        <option value="custom">Add Custom Regulation</option>
    </select>
    <input type="text" id="custom_regulation" name="custom_regulation" placeholder="Enter Custom Regulation" style="display: none; margin-top: 5px;">

                                        </div>  
                                        <div class="form-group" style="width: 30%;">
                                            <label for="sem" style = "text-align: left;">Semester</label>
                                            <select id="sem" name="sem">
                                            <!--    <option value="" disabled selected hidden>Select Semester</option>
                                                <option value="1">01</option>
                                                <option value="2">02</option>
                                                <option value="3">03</option>
                                                <option value="4">04</option>
                                                <option value="5">05</option>
                                                <option value="6">06</option>
                                                <option value="7">07</option>
                                                <option value="8">08</option>
                                                <option value="9">09</option>
                                                <option value="10">10</option>-->
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 30%;">
                                            <label for="num_subjects">No. of Subjects</label>
                                            <input type="number" id="num_subjects" placeholder="Enter number" min="1"> 
                                        </div>
                                    </div>
                                </div><br><br>  
                                <div class="error-message" id="form-error">
                                    Please fill in all the details before adding subjects.
                                </div><br><br>  
                                <div class = "button-container" style="display: flex; justify-content: flex-end; gap: 10px;">
                                <button type="button" id="add_button">+  Add</button>
                                <button type="button" id="view_button">View</button>
                                </div>
                                <br>
                                <br>
                                <div class="table-container">
                                    <table id="subjects_table">
                                        <thead>
                                            <tr>
                                                <th>Course Category</th>
                                                <th>Course Type</th>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Credit Points</th>
                                                <th>L</th>
                                                <th>T</th>
                                                <th>P</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <!-- Rows will be added here dynamically -->
                                        </tbody>
                                    </table><br><br>
                                    <div class = button-container>
                                        <button type="submit"  id="Submit_button" >Submit</button>
                                        <br><br>
                                    </div>
                                </div>
                                <div class="view-table-container" id="view-table-container" style="display: none;">
                                    <h4>Course Details</h4>
                                    <table id="view_subjects_table">
                                        <thead>
                                            <tr>
                                                <th>Course Category</th>
                                                <th>Course Type</th>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Credit Points</th>
                                                <th>L</th>
                                                <th>T</th>
                                                <th>P</th>
                                            </tr>
                                        </thead>
                                        <tbody id="view_tbody">
                                            <!-- Rows will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="course-details" id="course-details" style="display: none;">
                                    <h4>Course Details</h4>
                                    <div id="course-details-content"></div>
                                </div>
                                <script>
                                    document.getElementById('degree').addEventListener('change', function() {
                                        var degree = this.value;
                                        var branchSelect = document.getElementById('branch');
                                        var yearSelect = document.getElementById('year');
                                        // Reset branch options
                                        branchSelect.innerHTML = '<option value="" disabled selected hidden>Select Branch</option>';
                                        // Reset year options
                                        yearSelect.innerHTML = '<option value="" disabled selected hidden>Select Year</option>';
                                        
                                        var branches = [];
                                        var years = [];

                                        // Branch options for each degree
                                        if (degree === 'M.E') {
                                            branches = [
                                                {value: 'SE', text: 'Structural Engineering'},
                                                {value: 'CSE', text: 'Computer Science & Engineering'},
                                                {value: 'ED', text: 'Engineering Design'},
                                                {value: 'AE', text: 'Applied Electronics'}
                                            ];
                                            years = ['I','II'];
                                        } 
                                        else if (degree === 'B.E') {
                                            branches = [
                                                {value: 'AERO', text: 'Aeronautical Engineering'},
                                                {value: 'CSE', text: 'Computer Science & Engineering'},
                                                {value: 'ECE', text: 'Electrical & Communication Engineering'},
                                                {value: 'EEE', text: 'Electrical & Electronics Engineering'},
                                                {value: 'MECH', text: 'Mechanical Engineering'},
                                                {value: 'CIVIL', text: 'Civil Engineering'}
                                            ];
                                            years = ['I','II','III','IV'];
                                        }
                                        else if (degree === 'B.Tech'){
                                            branches = [
                                                {value: 'AIDS', text: 'Artificial Intelligence & Data Science'},
                                                {value: 'BIO', text: 'Bio Technology'},
                                                {value: 'CHEM', text: 'Chemical Engineering'},
                                                {value: 'IT', text: 'Information Technology'}
                                            ];
                                            years = ['I','II','III','IV'];
                                        }
                                        else if(degree === 'MBA'){
                                            branches = [{value: 'MBA', text: 'MBA'}];
                                            years = ['I','II'];
                                        }
                                        // Populate branch dropdown
                                        branches.forEach(function(branch) {
                                            var option = document.createElement('option');
                                            option.value = branch.value;
                                            option.text = branch.text;
                                            branchSelect.appendChild(option);
                                        });
                                        // Populate year dropdown
                                        years.forEach(function(year){
                                            var option = document.createElement('option');
                                            option.value = year;
                                            option.text = year;
                                            yearSelect.appendChild(option);
                                        });
                                    });

                                    document.getElementById('year').addEventListener('change', function() {
                                        var year = this.value;
                                        var semSelect = document.getElementById('sem');
                                        semSelect.innerHTML = '<option value="" disabled selected hidden>Select Semester</option>'; // Reset semesters

                                        var semesters = [];
                                        if (year === 'I') {
                                            semesters = ['01', '02'];
                                        } else if (year === 'II') {
                                            semesters = ['03', '04'];
                                        } else if (year === 'III') {
                                            semesters = ['05', '06'];
                                        } else if (year === 'IV') {
                                            semesters = ['07', '08'];
                                        } else if (year === 'V'){
                                            semesters = ['09','10'];
                                        }

                                        semesters.forEach(function(sem) {
                                            var option = document.createElement('option');
                                            option.value = sem;
                                            option.text = sem;
                                            semSelect.appendChild(option);
                                        });
                                    });

                                    var prev_row = 0;

                                    // Function to validate that all form fields are filled before adding the table
                                    document.getElementById('form-error').style.display = 'none'; 
                                    document.getElementById('add_button').addEventListener('click', function() {
                                        var degree = document.getElementById('degree').value;
                                        var branch = document.getElementById('branch').value;
                                        var year = document.getElementById('year').value;
                                        var regulation = document.getElementById('regulation').value;
                                        var sem = document.getElementById('sem').value;
                                        var numSubjects = document.getElementById('num_subjects').value;

                                        var errorMessage = document.getElementById('form-error');
                                        if (degree === 'MBA') {
                                            // Only validate the fields that are required for MBA
                                            if (!year || !regulation || !sem || !numSubjects) {
                                                errorMessage.style.display = 'block';
                                                return;
                                            } else {
                                                errorMessage.style.display = 'none';
                                            }
                                        } else {
                                            if (!degree || !branch || !year || !regulation || !sem || !numSubjects) {
                                                errorMessage.style.display = 'block';
                                                return;
                                            } else {
                                                errorMessage.style.display = 'none';
                                            }
                                        }

                                        var tableBody = document.getElementById('subjects_table').getElementsByTagName('tbody')[0];

                                        if (prev_row < numSubjects) {
                                            var i_t = numSubjects - prev_row;
                                            for (var i = 0; i < i_t; i++) {
                                                var row = tableBody.insertRow();
                                                row.setAttribute('data-id', ''); // Placeholder for ID

                                                // Insert columns
                                                var cell1 = row.insertCell(0);
                                                var cell2 = row.insertCell(1);
                                                var cell3 = row.insertCell(2);
                                                var cell4 = row.insertCell(3);
                                                var cell5 = row.insertCell(4);
                                                var cell6 = row.insertCell(5); 
                                                var cell7 = row.insertCell(6);
                                                var cell8 = row.insertCell(7);
                                                var cell9 = row.insertCell(8); // Edit column
                                                var cell10 = row.insertCell(9); // Delete column

                                                // Insert Input fields
                                                cell1.innerHTML = `
                                                    <select style="border:none;" name="courseCategory[]">
                                                        <option value="-">-</option>
                                                        <option value="PEC">PEC</option>
                                                        <option value="HSMC">HSMC</option>
                                                        <option value="BSC">BSC</option>
                                                        <option value="ESC">ESC</option>
                                                        <option value="EEC">EEC</option>
                                                        <option value="PCC">PCC</option>
                                                        <option value="MC">MC</option>
                                                        <option value="OEC">OEC</option>
                                                        <option value="FC">FC</option>
                                                        <option value="RMC">RMC</option>
                                                        <option value="AC">AC</option>
                                                    </select>
                                                `;
                                                cell2.innerHTML = `
                                                    <select style="border:none;" name="courseType[]">
                                                        <option value=" "> </option>
                                                        <option value="Theory">Theory</option>
                                                        <option value="Practical">Practical</option>
                                                        <option value="Theory cum Practical">Theory cum Practical</option>
                                                    </select>
                                                `;
                                                cell3.innerHTML = '<input type="text" placeholder="Enter Subject Code" style="text-align: left; color:#808080;" name="subjectCode[]">';
                                                cell4.innerHTML = '<input type="text" placeholder="Enter Subject Name" style="text-align: left; color:#808080;" name="subjectName[]">';
                                                cell5.innerHTML = '<input type="number" placeholder="Enter Credit Points" min="0" step="1" style="text-align: left; color:#808080; -moz-appearance: textfield; -webkit-appearance: none; appearance: none;" name="creditPoints[]">';
                                                cell6.innerHTML = '<input type="text" placeholder="L" style="text-align:left; color:#808080;" name="l[]">';
                                                cell7.innerHTML = '<input type="text" placeholder="T" style="text-align:left; color:#808080;" name="t[]">';
                                                cell8.innerHTML = '<input type="text" placeholder="P" style="text-align:left; color:#808080;" name="p[]">';
                                                cell9.innerHTML = `
                                                    <button type="button" class="edit-button" style="background: none; border: none; cursor: pointer;"> 
                                                        Edit 
                                                    </button>
                                                `;

                                                // Add Delete button with dustbin icon
                                                cell10.innerHTML = `
                                                    <button type="button" class="delete-button" style="background: none; border: none; cursor: pointer;">
                                                        <img src="dustbin_icon.png" alt="Delete" width="20px" height="auto">
                                                    </button>
                                                `;
                                            }
                                            prev_row = numSubjects;
                                        } else {
                                            var i_t = prev_row - numSubjects;
                                            for (i = 0; i < i_t; i++) {
                                                document.getElementById("tbody").getElementsByTagName("tr")[0].remove();
                                            }
                                            prev_row = numSubjects;
                                        }
                                        document.getElementById('Submit_button').style.display = 'block';
                                    });
                                    document.getElementById('view_button').addEventListener('click', function() {
                                        var table = document.getElementById('subjects_table');
                                        var viewTableBody = document.getElementById('view_tbody');
                                        var viewTableContainer = document.getElementById('view-table-container');
                                        var submitButton = document.getElementById('Submit_button'); // Reference to the submit button

                                        // Clear previous contents in the view table
                                        viewTableBody.innerHTML = '';

                                        // Check if the subjects table has rows
                                        if (table.rows.length > 1) { // Exclude header row
                                            // Loop through the subjects table rows and gather course details
                                            for (var i = 1; i < table.rows.length; i++) { // Start from 1 to skip header
                                                var cells = table.rows[i].cells;
                                                var row = viewTableBody.insertRow();

                                                // Insert cells into the view table
                                                for (var j = 0; j < cells.length - 2; j++) { // Exclude Edit and Delete columns
                                                    var newCell = row.insertCell(j);
                                                    newCell.innerHTML = cells[j].innerText; // Copy the text from the original table
                                                }
                                            }

                                            //Hide the original subjects table
                                            table.style.display = 'none';
                                            submitButton.style.display = 'none';

                                            // Show the view table container
                                            viewTableContainer.style.display = 'block';
                                        } else {
                                            alert('No subjects to display.');
                                        }
                                    });

                                    // Event delegation for dynamically added edit buttons             
                                    document.getElementById('subjects_table').addEventListener('click', function(e) {
                                        if (e.target && e.target.matches('.edit-button')) {
                                            var row = e.target.closest('tr');
                                            var cells = row.getElementsByTagName('td');

                                            // Change cells to input fields for editing
                                            for (var i = 0; i < cells.length - 2; i++) { // Exclude Edit and Delete columns
                                                var cellValue = cells[i].innerText;
                                                cells[i].innerHTML = `<input type="text" value="${cellValue}" style="width: 100%; border: none; outline: none; padding: 8px; color: #808080;">`;
                                            }

                                            // Hide the Edit button and show the Save button
                                            e.target.style.display = 'none'; // Hide Edit button
                                            var saveButton = document.createElement('button');
                                            saveButton.innerText = 'Save';
                                            saveButton.type = 'button';
                                            saveButton.classList.add('save-button');
                                            saveButton.style.background = 'none';
                                            saveButton.style.border = 'none';
                                            saveButton.style.cursor = 'pointer';

                                            saveButton.onclick = function() {
                                                // Gather updated values
                                                var updatedData = {
                                                    courseCategory: cells[0].querySelector('input').value,
                                                    courseType: cells[1].querySelector('input').value,
                                                    subjectCode: cells[2].querySelector('input').value,
                                                    subjectName: cells[3].querySelector('input').value,
                                                    creditPoints: cells[4].querySelector('input').value,
                                                    L: cells[5].querySelector('input').value,
                                                    T: cells[6].querySelector('input').value,
                                                    P: cells[7].querySelector('input').value,
                                                    id: row.getAttribute('data-id') // Get the data-id attribute for the row
                                                };

                                                // Send updated data to the backend
                                                fetch('update_subject.php', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify(updatedData) // Send the updated data as JSON
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log('Update successful:', data);
                                                    // Update the table with the new values
                                                    for (var i = 0; i < cells.length - 2; i++) {
                                                        cells[i].innerText = updatedData[Object.keys(updatedData)[i]]; // Update cell text
                                                    }
                                                    // Hide the Save button and show the Edit button
                                                    saveButton.style.display = 'none'; // Hide Save button
                                                    e.target.style.display = 'inline'; // Show Edit button
                                                })
                                                .catch(error => {
                                                    console.error('Update failed:', error);
                                                });
                                            };

                                            // Insert the Save button into the last cell (Edit column)
                                            cells[cells.length - 2].appendChild(saveButton); // Assuming Edit button is in the second last cell
                                        }
                                    });         
                                    
                                    // Event delegation for dynamically added delete buttons
                                    document.getElementById('subjects_table').addEventListener('click', function(e) {
                                        if (e.target && e.target.matches('img[alt="Delete"]')) {
                                            var row = e.target.closest('tr');
                                            row.parentNode.removeChild(row);

                                            // Optionally, hide the submit button if no rows are left
                                            var remainingRows = document.getElementById('subjects_table').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
                                            if (remainingRows === 0) {
                                                document.getElementById('Submit_button').style.display = 'none';
                                            }

                                            // Update the num_subjects field with the new row count
                                            document.getElementById('num_subjects').value = remainingRows;
                                        }
                                    }); 
                                    // Form validation on submit
function validateForm() {
    var degree = document.getElementById('degree').value;
    var courseCategories = document.getElementsByName('courseCategory[]');
    var courseTypes = document.getElementsByName('courseType[]');
    var subjectCodes = document.getElementsByName('subjectCode[]');
    var subjectNames = document.getElementsByName('subjectName[]');
    var creditPoints = document.getElementsByName('creditPoints[]');
    var l = document.getElementsByName('l[]');
    var t = document.getElementsByName('t[]');
    var p = document.getElementsByName('p[]');

    // If the degree is MBA, skip branch validation
    if (degree === 'MBA') {
        for (var i = 0; i < courseCategories.length; i++) {
            if (!courseCategories[i].value ||
                !courseTypes[i].value ||
                !subjectCodes[i].value.trim() ||
                !subjectNames[i].value.trim() ||
                !creditPoints[i].value.trim() ||
                !l[i].value.trim() ||
                !t[i].value.trim() ||
                !p[i].value.trim()) {
                alert('Please fill in all the fields for each subject.');
                return false;
            }
        }
    } else {
        // Validate all fields for other degrees
        var branch = document.getElementById('branch').value;
        if (!degree || !branch) {
            alert('Please fill in all the details before adding subjects.');
            return false;
        }
        for (var i = 0; i < courseCategories.length; i++) {
            if (!courseCategories[i].value ||
                !courseTypes[i].value ||
                !subjectCodes[i].value.trim() ||
                !subjectNames[i].value.trim() ||
                !creditPoints[i].value.trim() ||
                !l[i].value.trim() ||
                !t[i].value.trim() ||
                !p[i].value.trim()) {
                alert('Please fill in all the fields for each subject.');
                return false;
            }
        }
    }
    return true;
}
                                    
                                    // Add an event listener to fetch subjects when the form fields change
                                    document.getElementById('sem').addEventListener('change', fetchSubjects);
                                    document.getElementById('regulation').addEventListener('input', fetchSubjects);
                                    document.getElementById('year').addEventListener('change', fetchSubjects);
                                    document.getElementById('branch').addEventListener('change', fetchSubjects);
                                    document.getElementById('degree').addEventListener('change', fetchSubjects);

                                    function toggleCustomRegulation() {
    var regulationSelect = document.getElementById('regulation');
    var customRegulationInput = document.getElementById('custom_regulation');

    if (regulationSelect.value === 'custom') {
        customRegulationInput.style.display = 'block'; // Show the custom input
    } else {
        customRegulationInput.style.display = 'none'; // Hide the custom input
        customRegulationInput.value = ''; // Clear the custom input if not in use
    }
}

                                    function fetchSubjects() {
                                        var degree = document.getElementById('degree').value;
                                        var branch = document.getElementById('branch').value;
                                        var year = document.getElementById('year').value;
                                        var regulation = document.getElementById('regulation').value;
                                        var sem = document.getElementById('sem').value;

                                        // Check if all required fields are filled
                                        if (degree && branch && year && regulation && sem) {
                                            // Create an AJAX request
                                            var xhr = new XMLHttpRequest();
                                            xhr.open('GET', 'fetch_subjects.php?degree=' + degree + '&branch=' + branch + '&year=' + year + '&regulation=' + regulation + '&sem=' + sem, true);
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    var subjects = JSON.parse(xhr.responseText);
                                                    var tableBody = document.getElementById('tbody');

                                                    // Clear existing rows in the table
                                                    tableBody.innerHTML = '';

                                                    // Create a set to track existing subject codes
                                                    var existingSubjectCodes = new Set();

                                                    // Populate the set with existing subject codes in the table
                                                    var existingRows = tableBody.getElementsByTagName('tr');
                                                    for (var i = 0; i < existingRows.length; i++) {
                                                        var subjectCodeCell = existingRows[i].cells[2]; // Assuming subject code is in the 3rd column
                                                        if (subjectCodeCell) {
                                                            existingSubjectCodes.add(subjectCodeCell.innerText.trim());
                                                        }
                                                    }

                                                    // Append new subjects to the existing rows, checking for duplicates
                                                    subjects.forEach(function(subject) {
                                                        if (!existingSubjectCodes.has(subject.subject_code)) {
                                                            var row = tableBody.insertRow();
                                                            row.setAttribute('data-id', subject.id); // Set the unique ID for the row
                                                            row.insertCell(0).innerHTML = subject.course_category;
                                                            row.insertCell(1).innerHTML = subject.course_type;
                                                            row.insertCell(2).innerHTML = subject.subject_code;
                                                            row.insertCell(3).innerHTML = subject.subject_name;
                                                            row.insertCell(4).innerHTML = subject.credit_points;
                                                            row.insertCell(5).innerHTML = subject.L;
                                                            row.insertCell(6).innerHTML = subject.T;
                                                            row.insertCell(7).innerHTML = subject.P;
                                                            row.insertCell(8).innerHTML = `<button type="button" class="edit-button" style="background: none; border: none; cursor: pointer;"> 
                                                                                            Edit 
                                                                                       </button>`;
                                                            row.insertCell(9).innerHTML = `<button type="button" class="delete-button" style="background: none; border: none; cursor: pointer;">
                                                                                            <img src="dustbin_icon.png" alt="Delete" width="20px" height="auto">
                                                                                       </button>`;
                                                        }
                                                    });
                                                }
                                            };
                                            xhr.send();
                                        }
                                    }
                                    
                                    
                                    document.getElementById('subjectform').addEventListener('submit', function(e) {
                                        e.preventDefault(); // Prevent the default form submission behavior

                                        if (!validateForm()){
                                            return; // Stop submission if validation fails
                                        }
                                        var formData = new FormData(this); // Capture form data
                                        var submitButton = document.getElementById('Submit_button');
    
                                        // Remove existing success/error messages before adding a new one
                                        var existingMessage = document.getElementById('submissionMessage');
                                        if (existingMessage) {
                                            existingMessage.remove();
                                        }

                                        fetch('subjectbe.php', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest' // Indicate an AJAX request
                                            }
                                        })
                                        .then(response => response.json()) // Convert response to JSON
                                        .then(data => {
											console.log(data);
                                            var messageContainer = document.createElement("p"); // Create a paragraph element for the message
                                            messageContainer.id = "submissionMessage"; // Assign an ID for easy removal later
                                            messageContainer.style.textAlign = "center";
                                            messageContainer.style.fontWeight = "bold";
                                            messageContainer.style.marginTop = "10px";

                                            if (data.status === "success") {
                                                messageContainer.innerHTML = `<span style="color: green;">✅ ${data.message}</span>`;
                                            } else {
                                                messageContainer.innerHTML = `<span style="color: red;">❌ ${data.message}</span>`;
                                            }

                                            submitButton.insertAdjacentElement("afterend", messageContainer); // Place message below Submit button

                                            // Optionally, reset the form after submission
                                            document.getElementById('subjectform').reset();
                                        })
                                        .catch(error => {
                                            console.error("Error:", error);
                                            var errorMessage = document.createElement("p");
                                            errorMessage.id = "submissionMessage";
                                            errorMessage.innerHTML = `<span style="color: red;">❌ Submission failed. Please try again.</span>`;
                                            submitButton.insertAdjacentElement("afterend", errorMessage);
                                        });
                                    });

                                </script>
                            </form>
                        </div>
                        <!-- white card section end -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>