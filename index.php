<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>5 day weather forecast</title>
  <link rel="stylesheet" href="weather.css">
</head>
<body>
  <div class="container">
    <h1>5 day weather forecast</h1>
    <form method="POST">
      <input type="text" name="city" placeholder="Search city name for 5 day weather forecast">
      <button type="submit" name="getWeather">Get Forecast</button>
    </form>
    <div id="weatherInfo" class="grid-container">
      <?php
      if (isset($_POST['getWeather'])) {
        getWeather();
      }
      ?>
    </div>
  </div>
</body>
</html>

<?php
function getWeather() {
  $city = $_POST['city'];
  $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=ea8b04a9f72807c95ce660120d58ae07&units=metric";

  $response = file_get_contents($apiUrl);
  $data = json_decode($response, true);

  if ($data['cod'] === '200') {
    $groupedForecast = groupForecastByDay($data);
    foreach ($groupedForecast as $day => $dayForecast) {
      $dayName = date('l', strtotime($day));
      echo '<div class="forecast-box">';
      echo '<h3 class="day-title">' . $dayName . '</h3>';
      echo '<div class="forecast-items">';
      foreach ($dayForecast as $forecast) {
        $time = date('H:i', strtotime($forecast['dt_txt']));
        $temperature = $forecast['main']['temp'];
        $description = $forecast['weather'][0]['description'];
        echo '
          <div class="forecast-item">
          <p>-‘๑’--‘๑’--‘๑’--‘๑’--‘๑’--‘๑’--‘๑’--‘๑’-</p>
            <p>' . $time . '</p>
            <p>' . $description . '</p>
            <p>Temperature: ' . $temperature . ' °C</p>
            
            
          </div>';
      }
      echo '</div></div>';
    }
  } else {
    echo '<p>Error fetching weather data</p>';
  }
}

function groupForecastByDay($data) {
  $groupedForecast = array();
  foreach ($data['list'] as $forecast) {
    $day = date('Y-m-d', strtotime($forecast['dt_txt']));
    $groupedForecast[$day][] = $forecast;
  }
  return $groupedForecast;
}
?>
