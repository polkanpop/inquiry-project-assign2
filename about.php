<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    <title>About Us</title>
</head>
<body>
    <?php
        include_once "menu.inc";
    ?>

    <div class="container">
        
        <h1>About us</h1>
        <section class="group-info">
            <h2>Group information</h2>
            <dl>
                <dt><strong>Group Name:</strong></dt>
                    <dd>Khoi Khang</dd>
                <dt><strong>Group ID:</strong> </dt>
                    <dd>9112012</dd>
                <dt><strong>Tutor Name:</strong> </dt>
                    <dd>Trung Luu</dd>
                <dt><strong>Course:</strong></dt>
                    <dd>COS20016</dd>
            </dl>
    
    
            <br>
        
            <figure>
                <img class="member-image" src="./images/khang-photo.png" alt="a photo of khang">
                <figcaption>Hieu Khang</figcaption>
            </figure>
                
            <figure>
                <img class="member-image" src="./images/khoi-photo.png" alt="a photo of khoi">
                <figcaption>Dang Khoi</figcaption>
            </figure>


        </section>
        

    
        <hr>
    
        <h1>Timetable</h1>
        <table>

            <tr>
                <th></th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
    
            <tr>
                <td>7:00 AM - 11:00 AM</td>
                <td>Lecture</td>
                <td>Part time job</td>
                <td>Lecture</td>
                <td>Workout</td>  
                <td>Lecture</td>
            </tr>
    
            <tr>
                <td>12:00 AM - 3:00 PM</td>
                <td>Sleeping</td>
                <td>Workout</td>
                <td>Meeting</td>
                <td>Gaming</td>  
                <td>Self education</td>
            </tr>
    
            <tr>
                <td>3:00 PM - 6:00 PM</td>
                <td>Self education</td>
                <td>Workout</td>
                <td>Sleeping</td>
                <td>Gaming</td>  
                <td>Part time job</td>
            </tr>
    
            <tr>
                <td>6:00 PM - 9:00 PM</td>
                <td>Part time job</td>
                <td>Workout</td>
                <td>Self education</td>
                <td>Lecture</td>  
                <td>Gaming</td>
            </tr>
            
            <tr>
                <td>9:00 PM - 12:00 PM</td>
                <td>Sleeping</td>
                <td>Gaming</td>
                <td>Gaming</td>
                <td>Self education</td>  
                <td>Self education</td>
            </tr>
        </table>
    
        <hr>
    
        <h1>Contact</h1>
        <p>If you need anything from us, please contact us here</p>

        <dl>
            <dt>
                Khang Email:
            </dt>
            <dd>
                <a href="mailto:104993706@student.swin.edu.au"><img src="./images/khang-button.png" alt="a button to contact Khang via email"></a>
            </dd>
            <dt>
                Khoi Email:
            </dt>
            <dd>
                <a href="mailto:105241532@student.swin.edu.au">Nguyen Vo Dang Khoi</a>
            </dd>
        </dl>

    
        <hr>
    

        <h1>Additional Information</h1>
        <h3>Group Profile</h3>
        <p>Our group consists of 2 students from Vietmam with diverse backgrounds in programming, design, and project management.</p>
        <h3>Demographics</h3>
        <p>Age: 19</p>
        <p>Mixed academic backgrounds (Web Developer, AI Engineering)</p>
        <h3>Interests</h3>
        <p>Music:  Jazz, Jpop, US, UK</p>
        <P>Anime: Chainsaw Man, Blue Box, </P>
        <p>Sports: Badminton, Football</p>
    </div>
        <br>

    <?php
    include_once "footer.inc";
    ?>

    

</body>
</html> 