<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    <title>Apply</title>
</head>
<body>
    <?php
        include_once "menu.inc";
    ?>

    <div class="container">

        

        <form id="application" method="post" action="processEOI.php" novalidate ="novalidate">

            <h1>Application Form</h1>

                <fieldset class="apply-content">
                    <legend>Personal Information</legend>
                    <label for="jobRef">Job Reference Number: (exactly 5 alphanumeric characters)</label>
                    <input type="text" id="jobRef" name="jobRef" maxlength="5" pattern="[A-Za-z0-9]{5}" required>
            
                    <p>
                        <label for="1stName">First Name: </label>
                        <input type="text" id="1stName" name="1stName" pattern="[A-Za-z]+" maxlength="20" required>
            
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" pattern="[A-Za-z]+" maxlength="20" required>
                    </p>
            
                    <p>
                        <label for="date">Date Of Birth:</label>
                        <input type="text" id="date" name="DOB" placeholder="dd/mm/yyyy" required 
                        pattern="\d{2}/\d{2}/\d{4}" title="Please enter the date in dd/mm/yyyy format">
                    </p>
            
                    <fieldset>
                        <legend>Gender</legend>
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="male">Male</label><br>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label><br>
                        <input type="radio" id="other" name="gender" value="other">
                        <label for="other">Other</label>
                    </fieldset>
                </fieldset>

        <br>

            <fieldset class="apply-content">
                <legend>Address Details</legend>
                <p>
                <label for="strname">Street Address:</label>
                <input type="text" name="strname" id="strname" maxlength="40" required>
        
                <label for="suburb/town">Suburb / Town:</label>  
                <input type="text" name="suburb/town" id="suburb/town" maxlength="40" required>
                </p>
        
                <p>
                <label for="state">State</label>
                <select name="state" id="state" required>
                    <option value="">Please select</option>
                    <option value="state1">VIC</option>
                    <option value="state2">NSW</option>
                    <option value="state3">QLD</option>
                    <option value="state4">NT</option>
                    <option value="state5">WA</option>
                    <option value="state6">SA</option>
                    <option value="state7">TAS</option>
                    <option value="state8">ACT</option>
                </select>
                </p>
        
                <label for="pstcd">Postcode:</label>
                <input type="text" name="pstcd" id="pstcd" pattern="\d{4}" maxlength="4" required>
            </fieldset>
        
    
        <br>

            <fieldset class="apply-content">
                <legend>Contact Information</legend>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
        
                <br><br>
        
                <label for="teleNum">Telephone Number: (Enter from 8-12 digits)</label>
                <input type="text" id="teleNum" name="teleNum" pattern="^(\d\s?){8,12}$" required>
        
            </fieldset>

    
        
    
        <br>
    
        <fieldset class="apply-content">
            <legend>Skill</legend>
            <p>
            <label>
                <input type="checkbox" name="programlanguage[]" value="html" checked>HTML
            </label>
    
            <label>
                <input type="checkbox" name="programlanguage[]" value="css">CSS
            </label>
    
            <label>
                <input type="checkbox" name="programlanguage[]" value="php">PHP
            </label>
    
            <label>
                <input type="checkbox" name="programlanguage[]" value="mysql">MySQL
            </label>
    
            <label>
                <input type="checkbox" name="programlanguage[]" value="other">Other
            </label>
            </p>
    
            <p>
                <label for="add-skill">Additional skills:</label><br>
                <textarea name="add-skill" id="add-skill" rows="4" cols="20" 
                placeholder="If you have any other skills, please write it down here..."></textarea>
            </p>
        </fieldset>
    
            <p class="form-buttons">
                <input type="Submit" value="Send">
                <input type="reset" value="Reset Form">
            </p>
            
        </form>

        <a href="index.php" id="back-button">Go Back</a>
            
    </div>
    <br>
    <br>

    <?php
    include_once "footer.inc";
    ?>

</body>
</html>