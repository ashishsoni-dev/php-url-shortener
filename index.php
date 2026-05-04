<!DOCTYPE html>
<html>

<head>
    <title>URL Shortener</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <form action="save.php" method="POST">
            <input type="text" name="url" placeholder="Enter URL" required>
            <input type="text" name="custom" placeholder="Custom code (optional)">
            <input type="number" name="expiry" placeholder="Days to expire" min="1">
            <button type="submit">Submit</button>
        </form>
    </div>

</body>

</html>