/* eslint-disable indent */
function pageHandler() {
  console.log('Let\'s go!!!')

  const pageState = {
    countryData: null,
    searchResults: null
  }

  // DOM Variables
  const tableBody = document.querySelector('tbody')

  // Loading Data
  function setCountryData() {
    const countryData = sessionStorage.getItem('Data')
    const countryDataObj = JSON.parse(countryData)
    pageState['countryData'] = countryDataObj
    pageState['searchResults'] = countryDataObj
  }

  setCountryData()

  // Rendering Functionality
  function renderTable() {
    const searchResults = pageState['searchResults']
    if (searchResults.length === 0) {
      tableBody.innerHTML = `
            <tr>
                <td colspan=8>Could not find anything matching your search</td>
            </tr>
        `
    } else {
      tableBody.innerHTML = `
            ${searchResults.map((country, index) => {
                return `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${country.country_name}</td>
                        <td>${country.num_cyclists}</td>
                        <td>${country.avg_cyclist_age === 0 ? 'n/a' : country.avg_cyclist_age.toFixed(1)}</td>
                        <td>${country.gold}</td>
                        <td>${country.silver}</td>
                        <td>${country.bronze}</td>
                        <td>${country.total}</td>
                    </tr>
                `
            })}
        `.replaceAll(',', '')
    }
  }

  renderTable()

  // DOM Object Event Listeners
}

window.addEventListener('DOMContentLoaded', pageHandler)