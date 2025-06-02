<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>À propos</title>
    <?php include('includes/public/head_section.php'); ?>
</head>

<?php include('includes/public/navbar.php'); ?>

<body>
<div class="container" style="max-width: 800px; margin: 2rem auto; padding: 1rem;">
    <h2 style="margin-bottom: 1rem;">Who We Are</h2>
    <p style="font-size: 1.1rem; line-height: 1.6;">
        Welcome to MyWebsite!

    <h3 style="margin-top: 2rem;">Our Story</h3>
    <p style="font-size: 1.1rem; line-height: 1.6;">
        Founded in 2025, MyWebsite gathers users from all over the world to share inspiring articles on a wide range of topics.
    </p>

    <h3 style="margin-top: 2rem;">The Founders</h3>
    <ul style="font-size: 1.1rem; line-height: 1.6; padding-left: 1.5rem;">
        <li>Timothée and Clara</li>
        <li>Two computer science students, at INSA Centre-Val-de-Loire</li>
    </ul>
</div>

<div class="footer" style="text-align: center; padding: 1rem; background-color: #eee; margin-top: 3rem;">
    &copy; <?php echo date("Y"); ?> MyWebsite. All rights reserved.
</div>

</body>
</html>
