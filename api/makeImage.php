<?php
function makeImage($hue) {
    $colorize = hueToRGB($hue);

    $imgSize = 1536;
    $halfImgSize = $imgSize / 2;
    $quarterImgSize = $imgSize / 4;

    $imgParams = array(
        'hue' => $hue,
        'brightnessMin' => 10,
        'brightnessMax' => 100
    );


    // make the image
    $image = imagecreatetruecolor($imgSize, $imgSize);
    imageantialias($image, true);
    imagealphablending($image, false);
    $black = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $black);
    imagesavealpha($image, true);
    imagealphablending($image, true);


    // make the shapes
    $totalShapes = rand(8, 12);
    for ($i = 0; $i < $totalShapes; $i++) {
        $shapeType = rand(0, 3); // 0 = ellipse, 1 = penta, 2 = triangle
        if ($shapeType == 0) {
            $alpha;
            $alphaRand = rand(0, 2);
            if ($alphaRand == 0) {
                $alpha = rand(48, 70);
            } else {
                $alpha = 0;
            }

            $rgb = randomColor($imgParams, $colorize);
            $ellipseColor = imagecolorallocatealpha(
                $image, 
                $rgb[0], 
                $rgb[1], 
                $rgb[2], 
                $alpha
            );

            imagefilledellipse(
                $image, 
                rand(0, $imgSize), // x
                rand(0, $imgSize), // y
                rand(5, $halfImgSize), // width
                rand(5, $halfImgSize), // height
                $ellipseColor
            );
        } elseif ($shapeType == 1) {
            $alpha;
            $alphaRand = rand(0, 2);
            if ($alphaRand == 0) {
                $alpha = rand(48, 70);
            } else {
                $alpha = 0;
            }

            $rgb = randomColor($imgParams, $colorize);
            $pentaColor = imagecolorallocatealpha(
                $image, 
                $rgb[0], 
                $rgb[1], 
                $rgb[2], 
                $alpha
            );

            $points = array(
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize)
            );

            imagefilledpolygon(
                $image,
                $points,
                6,
                $pentaColor
            );
        } else {
            $alpha;
            $alphaRand = rand(0, 2);
            if ($alphaRand == 0) {
                $alpha = rand(20, 70);
            } else {
                $alpha = 0;
            }
            
            $rgb = randomColor($imgParams, $colorize);
            $triColor = imagecolorallocatealpha(
                $image, 
                $rgb[0], 
                $rgb[1], 
                $rgb[2], 
                $alpha
            );

            $points = array(
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize),
                rand(0, $imgSize), rand(0, $imgSize)
            );

            imagefilledpolygon(
                $image, 
                $points, 
                3, 
                $triColor
            );
        }
    }

    $croppedImage = imagecreatetruecolor($halfImgSize, $halfImgSize);
    imagealphablending($croppedImage, false);
    imagefill($croppedImage, 0, 0, $black);
    imagesavealpha($croppedImage, true);
    imagealphablending($croppedImage, true);
    imagecopy($croppedImage, $image, 0, 0, $quarterImgSize, $quarterImgSize, $halfImgSize, $halfImgSize);
    imagealphablending($croppedImage, true);


    // make the four kaleidoscope image parts
    $xFlipped = imagecreatetruecolor($halfImgSize, $halfImgSize);
    imagealphablending($xFlipped, false);
    imagefill($xFlipped, 0, 0, $black);
    imagesavealpha($xFlipped, true);
    imagealphablending($xFlipped, true);
    imagecopy($xFlipped, $croppedImage, 0, 0, 0, 0, $halfImgSize, $halfImgSize);
    imageflip($xFlipped, IMG_FLIP_HORIZONTAL);

    $yFlipped = imagecreatetruecolor($halfImgSize, $halfImgSize);
    imagealphablending($yFlipped, false);
    imagefill($yFlipped, 0, 0, $black);
    imagesavealpha($yFlipped, true);
    imagealphablending($yFlipped, true);
    imagecopy($yFlipped, $croppedImage, 0, 0, 0, 0, $halfImgSize, $halfImgSize);
    imageflip($yFlipped, IMG_FLIP_VERTICAL);
    
    $rotated = imagecreatetruecolor($halfImgSize, $halfImgSize);
    imagealphablending($rotated, false);
    imagefill($rotated, 0, 0, $black);
    imagesavealpha($rotated, true);
    imagealphablending($rotated, true);
    imagecopy($rotated, $croppedImage, 0, 0, 0, 0, $halfImgSize, $halfImgSize);
    $rotated = imagerotate($rotated, 180, 0);
    

    // put the four parts together
    $bigImage = imagecreatetruecolor($imgSize, $imgSize);
    imagealphablending($bigImage, false);
    imagefill($bigImage, 0, 0, $black);
    imagesavealpha($bigImage, true);
    imagealphablending($bigImage, true);
    imagecopy($bigImage, $croppedImage, 0, 0, 0, 0, $halfImgSize, $halfImgSize);
    imagecopy($bigImage, $xFlipped, $halfImgSize, 0, 0, 0, $halfImgSize, $halfImgSize);
    imagecopy($bigImage, $yFlipped, 0, $halfImgSize, 0, 0, $halfImgSize, $halfImgSize);
    imagecopy($bigImage, $rotated, $halfImgSize, $halfImgSize, 0, 0, $halfImgSize, $halfImgSize);


    // resize to make smaller
    $smallSize = 512;
    $smallImage = imagecreatetruecolor($smallSize, $smallSize);
    imagealphablending($smallImage, false);
    imagefill($smallImage, 0, 0, $black);
    imagesavealpha($smallImage, true);
    imagealphablending($smallImage, true);
    imagecopyresampled($smallImage, $bigImage, 0, 0, 0, 0, $smallSize, $smallSize, $imgSize, $imgSize);
    

    // output the image
    $fileName = "xavatar-" . randomString() . ".png";

    ob_start();
    imagepng($smallImage);
    $bytes = ob_get_clean();
    $base64 = base64_encode($bytes);

    $output = "<a href='data:image/png;base64,$base64' download='" . $fileName . "'>";
    $output .= "<img src='data:image/png;base64,$base64' alt='" . $fileName . "'" . "height='$smallSize' width='$smallSize' />";
    $output .= "</a>";

    imagedestroy($image);
    imagedestroy($xFlipped);
    imagedestroy($yFlipped);
    imagedestroy($rotated);
    imagedestroy($bigImage);
    imagedestroy($smallImage);

    return $output;
}

function randomColor($colorParams, $colorize) {
    $brMin = $colorParams['brightnessMin'];
    $brMax = $colorParams['brightnessMax'];

    $sat = rand(20, 100) / 100;
    $maxChannelKey = array_search(max($colorize), $colorize);
    for ($i = 0; $i < count($colorize); $i++) {
        if ($i == $maxChannelKey) {
            continue;
        }

        $colorize[$i] = $colorize[$maxChannelKey] - intval(($colorize[$maxChannelKey] - $colorize[$i]) * $sat);
    }

    $value = rand(intval($brMin), intval($brMax)) / 100;
    $rgb = array(
        $value,
        $value,
        $value
    );

    if (count($colorize)) {
        $rgb = array(
            intval($rgb[0] * $colorize[0]),
            intval($rgb[1] * $colorize[1]),
            intval($rgb[2] * $colorize[2])
        );
    }
    return $rgb;
}

function hueToRGB($hue) {
    $rgb = array(0, 0, 0);

    if ($hue >= 0 && $hue < 60) {
        $rgb[0] = 255;
        $rgb[1] = intval(255 * ($hue / 60));
    } elseif ($hue >= 60 && $hue < 120) {
        $rgb[0] = intval(255 * ((120 - $hue) / 60));
        $rgb[1] = 255;
    } elseif ($hue >= 120 && $hue < 180) {
        $rgb[1] = 255;
        $rgb[2] = intval(255 * (($hue - 120) / 60));
    } elseif ($hue >= 180 && $hue < 240) {
        $rgb[1] = intval(255 * ((240 - $hue) / 60));
        $rgb[2] = 255;
    } elseif ($hue >= 240 && $hue < 300) {
        $rgb[0] = intval(255 * (($hue - 240) / 60));
        $rgb[2] = 255;
    } elseif ($hue >= 300 && $hue < 360) {
        $rgb[0] = 255;
        $rgb[2] = intval(255 * ((360 - $hue) / 60));
    }

    return $rgb;
}

function randomString(
    $length = 10, 
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
) {
    $output = '';
    for ($i = 0; $i < $length; $i++) {
        $output .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $output;
}
?>