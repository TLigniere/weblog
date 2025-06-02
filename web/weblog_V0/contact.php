<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement Utilisateur</title>
    <?php include('includes/public/head_section.php'); ?>
</head>

<?php include('includes/public/navbar.php'); ?>

<body>

<div class="container">

    <br>
    <h2>Send us a message</h2>
    <br>

    <form method="post" action="#">

        <label for="name">Your Name</label>
        <br>
        <input 
            type="text" 
            id="name" 
            name="name" 
            placeholder="Jane Doe" 
            required
        >
        <br>

        <label for="email">Your Email</label>
        <br>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="jane@example.com" 
            required
        >
        <br>

        <label for="message">Message</label>
        <br>
        <textarea 
            id="message" 
            name="message" 
            placeholder="Write your message here..." 
            required
            style="padding: 0.5rem; font-size: 1rem; width: 100%; min-height: 150px; resize: vertical;"
        ></textarea>
        <br>

        <button type="submit">
            Send Message
        </button>

    </form>

</div>

<div class="footer">
    &copy; <?php echo date("Y"); ?> MyWebsite. All rights reserved.
</div>

</body>
</html>

