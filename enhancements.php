<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    <title>Enhancements</title>
    <style>
        .enhancement {
            background-color: #f0f8ff;
            border: 1px solid #2c79d1;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .code {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
            font-family: monospace;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <?php
        include_once "menu.inc";
    ?>

    <div class="container">
        <h1>Website Enhancements</h1>

        <div class="enhancement">
            <h2>1. CSS Animation for Hero Section</h2>
            <p>We've added a subtle animation to the hero section on the home page to improve user engagement.</p>
            <h3>Implementation:</h3>
            <div class="code">
.hero {
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/animation" target="_blank">MDN Web Docs - CSS Animations</a></p>
            <p>Applied here: <a href="index.html#hero">Home Page Hero Section</a></p>
        </div>

        <div class="enhancement">
            <h2>2. Responsive Design for Mobile and Tablet</h2>
            <p>We've implemented a responsive design that adapts the layout for mobile and tablet screens.</p>
            <h3>Implementation:</h3>
            <div class="code">
@media (max-width: 768px) {
    .container {
        width: 95%;
    }
    .hero-content {
        padding: 1rem;
    }
    .hero h1 {
        font-size: 2rem;
    }
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/Media_Queries/Using_media_queries" target="_blank">MDN Web Docs - Using Media Queries</a></p>
            <p>Applied throughout the website. Example: <a href="index.html">Home Page</a></p>
        </div>

        <div class="enhancement">
            <h2>3. Interactive Job Listings</h2>
            <p>We've added an interactive feature to the job listings page that allows users to expand job descriptions.</p>
            <h3>Implementation:</h3>
            <div class="code">
&lt;details&gt;
    &lt;summary&gt;Job Title&lt;/summary&gt;
    &lt;p&gt;Full job description...&lt;/p&gt;
&lt;/details&gt;

details summary {
    cursor: pointer;
}

details[open] summary {
    font-weight: bold;
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details" target="_blank">MDN Web Docs - &lt;details&gt;: The Details disclosure element</a></p>
            <p>Applied here: <a href="jobs.html">Jobs Page</a></p>
        </div>
    </div>
    <br>
    <br>
    
    <?php
    include_once "footer.inc";
    ?>

</body>
</html>