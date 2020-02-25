<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Oeger.li Services</title>
</head>

<body>
  <div class="dashboard">
    <div class="title" title="Maurices Services">
      <h1>Maurices Services</h1>
    </div>
    <div class="items">
      <?php
      require 'vendor/autoload.php';

      use League\ColorExtractor\Palette;
      use League\ColorExtractor\Color;

      function get_rgb_color($color, $transparency)
      {
        return 'rgba(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $transparency . ')';
      }

      $servicesString = file_get_contents('./services.json');
      $services = json_decode($servicesString);

      foreach ($services as $key => $service) {
        $palette = Palette::fromFilename($service->image);

        $topTwo = (array) $palette->getMostUsedColors(2);

        $firstColor = Color::fromIntToRgb(key(array_slice($topTwo, 0, 1, true)));
        $secondColor = Color::fromIntToRgb(key(array_slice($topTwo, 1, 1, true)));

        $firstColor = $firstColor['r'] == 255 && $firstColor['g'] == 255 && $firstColor['b'] == 255 ? $secondColor : $firstColor;
        $secondColor = $secondColor['r'] == 255 && $secondColor['g'] == 255 && $secondColor['b'] == 255 ? $firstColor : $secondColor;

        $firstColorRgb = get_rgb_color($firstColor, 1);
        $secondColorRgb = get_rgb_color($secondColor, 0.6);

        $colorGradient = 'linear-gradient(153deg, ' . $firstColorRgb . ' 0%, ' . $secondColorRgb . ' 20%, #46464666 80%)';

        $item = '
          <a class="item" href="' . $service->url . '" target="_blank">
            <div class="logo-container" style="background: ' . $colorGradient . '">
              <img class="logo" src="' . $service->image . '" />
            </div>
            <h2 class="title">' . $service->name . '</h2>
          </a>';

        echo $item;
      }
      ?>
    </div>
  </div>
</body>

</html>