
async function fetchFuction() {
    document.getElementById("weatherInfo").innerHTML = ``;
    const cityAndCountry = document.getElementById("cityCountry").value;
    console.log(cityAndCountry);
    const urlFiveDay = `https://api.openweathermap.org/data/2.5/forecast?q=${cityAndCountry}&units=metric&appid=a98a4131ea20b87b48c10dd8624aaf50`;
    const responseFiveDay = await fetch(urlFiveDay);
    const dataFiveDay = await responseFiveDay.json();
    console.log(dataFiveDay);
    for (const item of dataFiveDay.list) {
        resultHandleFiveDay(item.main.temp, item.main.feels_like, item.dt_txt);
    }
}

function xmlRequestFunction () {
    document.getElementById("weatherInfo").innerHTML = ``;
    const cityAndCountry = document.getElementById("cityCountry").value;
    const urlCurrent = `https://api.openweathermap.org/data/2.5/weather?q=${cityAndCountry}&units=metric&appid=a98a4131ea20b87b48c10dd8624aaf50`;
    const request = new XMLHttpRequest();
    request.open('GET', urlCurrent);
    request.onload = () => {
        const dataCurrent = JSON.parse(request.responseText);
        resultHandleCurrent(dataCurrent.main.temp, dataCurrent.main.feels_like, dataCurrent.main.humidity, dataCurrent.weather[0].main);
        console.log(dataCurrent);
    }
    request.send();
}

function resultHandleCurrent(temperature, feelsLikeTemp, humidity, description, dateTime) {
    document.getElementById("weatherInfo").innerHTML += `
    <div id="currentTemperature">
    <h1>CURRENT WEATHER</h1>
    <p>Temperature: ${temperature} Celsius</p>
    <p>Feels like temperature: ${feelsLikeTemp} Celsius</p>
    <p>Humidity: ${humidity}%</p>
    <p>Description: ${description}</p>
    </div>
    `;
}
function resultHandleFiveDay(temperature, feelsLikeTemp, dateTime){
    document.getElementById("weatherInfo").innerHTML += `
    <div class="tempBlock">
    <p>Date/Time: ${dateTime}</p>
    <p>Temperature: ${temperature} Celsius</p>
    <p>Feels like temperature: ${feelsLikeTemp} Celsius</p>
    </div>
    `;
}
