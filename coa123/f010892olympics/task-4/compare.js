/* eslint-disable indent */
function pageHandler() {

    var pageState = {
        all_countries: null,
        country_1: null,
        country_2: null
    }

// DOM Variables
    const textInputs = document.querySelectorAll('input')
    const submitBtn1 = document.querySelector('#submit-1')
    const submitBtn2 = document.querySelector('#submit-2')
    const infoWrapper1 = document.querySelector('#wrapper-1')
    const infoWrapper2 = document.querySelector('#wrapper-2')

// Loading Data
    function setCountryData() {
        var countryData = sessionStorage.getItem('Data')
        pageState['all_countries'] = JSON.parse(countryData)

        var urlParams = new URLSearchParams(window.location.search)
        const firstCountry = urlParams.get('first_country')
        const secondCountry = urlParams.get('second_country')
        if (firstCountry && secondCountry) {
            const firstCountryObj = pageState['all_countries'].find(country => country.ISO_id === firstCountry)
            const secondCountryObj = pageState['all_countries'].find(country => country.ISO_id === secondCountry)
            textInputs[0].value = firstCountry
            textInputs[1].value = secondCountry
            renderInfo(infoWrapper1, firstCountryObj)
            renderInfo(infoWrapper2, secondCountryObj)
        }
    }

setCountryData()
console.log(pageState)

// Search Functionality
    function getCountry(searchString) {
        const searchResult = pageState.all_countries.find(country => {
        return country['ISO_id'] === searchString
        })
        return searchResult
    }

  // Rendering Functionality
    function setCountry(countryObj, columnValue) {
        if (columnValue === 1) {
        renderInfo(infoWrapper1, countryObj)
        } else if (columnValue === 2) {
        renderInfo(infoWrapper2, countryObj)
        }
    }

    function renderInfo(domObj, countryInfo) {
        domObj.innerHTML = `
            <div class="country-info">
                <h2>${countryInfo.country_name} (${countryInfo.ISO_id})</h2>
                <h3>Population: ${countryInfo.population}</h3>
                <h3>GDP: $${countryInfo.gdp}</h3>
                <h3>Total Medals: ${countryInfo.total}</h3>
                <ul>
                    <li>Gold: ${countryInfo.gold}</li>
                    <li>Silver: ${countryInfo.silver}</li>
                    <li>Bronze: ${countryInfo.bronze}</li>
                </ul>
                ${countryInfo.cyclists.length > 0 ?
                    `
                    <div class="table-wrapper">
                        <table>
                            <tr>
                                <th colspan="8" class="main-heading">Olympic Cyclists</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Height (cm)</th>
                                <th>Weight (kg)</th>
                                <th>Sport</th>
                                <th>Event</th>
                            </tr>
                        ${countryInfo.cyclists.map(cyclist => {
                            return `
                                <tr>
                                    <td>${cyclist.name}</td>
                                    <td>${cyclist.gender}</td>
                                    <td>${cyclist.age}</td>
                                    <td>${cyclist.height}</td>
                                    <td>${cyclist.weight}</td>
                                    <td>${cyclist.sport}</td>
                                    <td>${cyclist.Event.replaceAll(',', ';')}</td>
                                </tr>
                            `
                        })}
                        </table>
                    </div>
                    `.replaceAll(',', '')
                    : 
                    '<h3>This country has no cyclists<h3>'}
            </div>
            `
    }

  // DOM Object Event Listeners
    function searchHandler(e) {
        e.preventDefault()
        const btnValue = parseInt(e.target.value)
        const countryObj = getCountry(textInputs[btnValue - 1].value)
        if (countryObj) {
        setCountry(countryObj, btnValue)
        }
    }

    function validateInput(e) {
        var inputString = e.target.value.trim().toLowerCase()
        inputString.split('').forEach(char => {
        if (!char.match('[a-z]')) {
            inputString = inputString.replace(char, '')
        }
        })
        e.target.value = inputString.toUpperCase()
    }

    textInputs.forEach(form => {
        form.addEventListener('input', validateInput)
    })

    submitBtn1.addEventListener('click', searchHandler)
    submitBtn2.addEventListener('click', searchHandler)
}

window.addEventListener('DOMContentLoaded', pageHandler)