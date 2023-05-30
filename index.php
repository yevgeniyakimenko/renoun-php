<?php 
require_once 'makeImage.php'; 
$hue = (
    isset($_REQUEST['hue'])
    && $_REQUEST['hue'] >= 0
    && $_REQUEST['hue'] <= 359
) 
    ? $_REQUEST['hue'] 
    : 280;

$image = makeImage($hue);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <link rel="icon" href="dice-five-solid.svg">
    <title>X-Avatar</title>
</head>

<body>
    <div class="content">
        <h1>🎲 X-Avatar</h1>

        <form action="index.php" method="get">
            <div class="form-section">
                <label for="hue">
                    Hue
                </label>
                <input type="range" 
                    name="hue" 
                    id="hue" 
                    min="0" 
                    max="359" 
                    value="<?php echo $hue; ?>"
                >

                <div class="hue-box"></div>
            </div>

            <div class="form-section">
                <input type="submit" value="Roll">
            </div>
        </form>

        <p>
            Click the image to save it.
        </p>

        <div class="image-container">
            <?php echo $image; ?>
        </div>

        <p>
            © Yevgeniy Akimenko
        </p>
    </div>
</body>
</html>