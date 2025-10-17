const locationEl = document.getElementById('location');
const weatherCardsEl = document.getElementById('weather-cards');
const activityEl = document.getElementById('activity');
const locationBtn = document.getElementById('location-btn');
const conditionIconEl = document.getElementById('condition-icon');

const OPENWEATHER_API_KEY = 'a99233cfaaa96194e757897b529ffeab';
const DEFAULT_LOCATION = { lat: 42.7284, lon: -73.6901, name: 'Troy, NY' };

// Helper to convert UNIX time to local time string
function formatTime(unix, timezoneOffset) {
    const date = new Date((unix + timezoneOffset) * 1000);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

// Fetch weather data
async function getWeather(lat, lon) {
    const response = await fetch(
        `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=imperial&appid=${OPENWEATHER_API_KEY}`
    );
    if (!response.ok) throw new Error('Weather fetch failed');
    return await response.json();
}

// Fetch activity from Le Wagon Bored API
async function getActivity() {
    try {
        const response = await fetch('https://bored.api.lewagon.com/api/activity');
        if (!response.ok) throw new Error('Activity fetch failed');
        const data = await response.json();
        return data.activity;
    } catch {
        return 'Do something fun!';
    }
}

// Display weather and activity
async function displayWeatherAndActivity(lat, lon, fallbackLocationName) {
    try {
        const weatherData = await getWeather(lat, lon);
        const tz = weatherData.timezone;

        // Update location using the actual city name from API
        locationEl.textContent = weatherData.name || fallbackLocationName;

        // Update condition icon
        const iconCode = weatherData.weather[0].icon;
        conditionIconEl.src = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
        conditionIconEl.alt = weatherData.weather[0].description;

        // Weather details cards
        const weatherDetails = [
            { label: 'Temperature', value: `${weatherData.main.temp.toFixed(1)}°F` },
            { label: 'Feels Like', value: `${weatherData.main.feels_like.toFixed(1)}°F` },
            { label: 'Min Temp', value: `${weatherData.main.temp_min.toFixed(1)}°F` },
            { label: 'Max Temp', value: `${weatherData.main.temp_max.toFixed(1)}°F` },
            { label: 'Humidity', value: `${weatherData.main.humidity}%` },
            { label: 'Pressure', value: `${weatherData.main.pressure} hPa` },
            { label: 'Wind', value: `${weatherData.wind.speed} mph` },
            { label: 'Conditions', value: weatherData.weather[0].description },
            { label: 'Sunrise', value: formatTime(weatherData.sys.sunrise, tz) },
            { label: 'Sunset', value: formatTime(weatherData.sys.sunset, tz) }
        ];

        weatherCardsEl.innerHTML = '';
        weatherDetails.forEach(detail => {
            const card = document.createElement('div');
            card.classList.add('card');
            card.innerHTML = `<h4>${detail.label}</h4><p>${detail.value}</p>`;
            weatherCardsEl.appendChild(card);
        });

        // Activity
        const weatherMain = weatherData.weather[0].main.toLowerCase();
        let activity = '';
        if (weatherMain.includes('rain')) {
            activity = 'Read a book or watch a movie indoors.';
        } else if (weatherMain.includes('cloud')) {
            activity = await getActivity();
        } else if (weatherMain.includes('clear')) {
            activity = 'Go for a walk or a picnic!';
        } else if (weatherMain.includes('snow')) {
            activity = 'Build a snowman or have a snowball fight!';
        } else {
            activity = await getActivity();
        }
        activityEl.textContent = activity;

    } catch (err) {
        console.error(err);
        weatherCardsEl.innerHTML = '';
        activityEl.textContent = 'Could not fetch weather data.';
        conditionIconEl.src = '';
    }
}

// Default location on page load
displayWeatherAndActivity(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lon, DEFAULT_LOCATION.name);

// User location button
locationBtn.addEventListener('click', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                displayWeatherAndActivity(pos.coords.latitude, pos.coords.longitude, DEFAULT_LOCATION.name);
            },
            () => {
                alert('Unable to access your location.');
                displayWeatherAndActivity(DEFAULT_LOCATION.lat, DEFAULT_LOCATION.lon, DEFAULT_LOCATION.name);
            }
        );
    } else {
        alert('Geolocation not supported.');
    }
});
