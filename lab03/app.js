// ====== OpenWeatherMap Key ======
const OWM_KEY = "a99233cfaaa96194e757897b529ffeab";

// Default coordinates (Troy, NY)
let lat = 42.72841;
let lon = -73.69179;

// ====== WEATHER ======
async function getWeather(lat, lon) {
  const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${OWM_KEY}&units=imperial`;
  const response = await fetch(url);
  const data = await response.json();
  console.log("Weather data:", data);

  const name = data.name;
  const temp = data.main.temp;
  const tempMin = data.main.temp_min;
  const tempMax = data.main.temp_max;
  const feelsLike = data.main.feels_like;
  const humidity = data.main.humidity;
  const pressure = data.main.pressure;
  const windSpeed = data.wind.speed;
  const description = data.weather[0].description;
  const sunrise = new Date(data.sys.sunrise * 1000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
  const sunset = new Date(data.sys.sunset * 1000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

  // Populate weather boxes
  const weatherMain = document.getElementById("weatherMain");
  weatherMain.innerHTML = `
    <div class="weather-box weather-location"></div>
    <div class="weather-box weather-desc">${description}</div>
    <div class="weather-box weather-temp">Temp: ${temp}°F</div>
    <div class="weather-box weather-feels">Feels like: ${feelsLike}°F</div>
    <div class="weather-box weather-min">Min: ${tempMin}°F</div>
    <div class="weather-box weather-max">Max: ${tempMax}°F</div>
    <div class="weather-box weather-humidity">Humidity: ${humidity}%</div>
    <div class="weather-box weather-pressure">Pressure: ${pressure} hPa</div>
    <div class="weather-box weather-wind">Wind: ${windSpeed} mph</div>
    <div class="weather-box weather-sun">Sunrise: ${sunrise} | Sunset: ${sunset}</div>
  `;

  // Typewriter effect for city
  const cityElement = weatherMain.querySelector(".weather-location");
  typeCityName(cityElement, name, 120);

  // Set weather icons (still only on card if needed)
  setWeatherVisuals(data.weather[0].main);

  // Activity suggestion based on weather
  getActivity(data.weather[0].main);
}

// ====== Typewriter effect ======
function typeCityName(element, text, speed = 100) {
  element.textContent = "";
  let i = 0;
  function type() {
    if (i < text.length) {
      element.textContent += text[i];
      i++;
      setTimeout(type, speed);
    }
  }
  type();
}

// ====== Set weather icons only (no background) ======
function setWeatherVisuals(weatherMain) {
  const weatherCard = document.querySelector("#weather-card");
  weatherCard.classList.remove("weather-clear","weather-clouds","weather-rain","weather-snow");

  const condition = weatherMain.toLowerCase();
  if (condition.includes("rain") || condition.includes("drizzle")) weatherCard.classList.add("weather-rain");
  else if (condition.includes("snow")) weatherCard.classList.add("weather-snow");
  else if (condition.includes("cloud")) weatherCard.classList.add("weather-clouds");
  else weatherCard.classList.add("weather-clear");
}

// ====== ACTIVITY RECOMMENDATION ======
async function getActivity(weatherCondition) {
  let activityTypes = ["recreational"];

  if (weatherCondition) {
    const cond = weatherCondition.toLowerCase();
    if (cond.includes("rain") || cond.includes("snow") || cond.includes("drizzle")) activityTypes = ["education", "relaxation"];
    else if (cond.includes("clear") || cond.includes("cloud")) activityTypes = ["recreational"];
    else if (cond.includes("extreme") || cond.includes("hot") || cond.includes("cold")) activityTypes = ["education", "relaxation"];
  }

  const randomType = activityTypes[Math.floor(Math.random() * activityTypes.length)];
  const url = `https://bored.api.lewagon.com/api/activity?type=${randomType}`;
  const response = await fetch(url);
  const data = await response.json();
  console.log("Activity data:", data);

  let activity = data.activity || "No activity available.";

  if (weatherCondition) {
    const cond = weatherCondition.toLowerCase();
    if (cond.includes("rain") || cond.includes("snow") || cond.includes("drizzle") || cond.includes("extreme") || cond.includes("hot") || cond.includes("cold")) {
      activity += ", great for staying inside";
    } else activity += ", perfect for today's weather!";
  }

  const activityElem = document.getElementById("activity");
  activityElem.textContent = activity;

  // Add fade-in effect
  activityElem.classList.remove("fade-in"); // reset
  void activityElem.offsetWidth; // trigger reflow
  activityElem.classList.add("fade-in");
}

// ====== HTML5 GEOLOCATION ======
function useMyLocation() {
  if (!navigator.geolocation) { alert("Geolocation not supported."); return; }
  navigator.geolocation.getCurrentPosition(
    pos => {
      lat = pos.coords.latitude;
      lon = pos.coords.longitude;
      getWeather(lat, lon);
    },
    err => alert("Could not get location: " + err.message)
  );
}

// ====== INITIAL LOAD ======
getWeather(lat, lon);
