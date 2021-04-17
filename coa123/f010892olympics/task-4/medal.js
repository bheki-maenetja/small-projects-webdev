function pageHandler() {
  console.log('Let\'s go!!!')

  const pageState = {
    countryData: null,
    searchResults: null
  }

  // DOM Variables

  // Loading Data
  function setCountryData() {
    const countryData = sessionStorage.getItem('Data')
    const countryDataObj = JSON.parse(countryData)
    pageState['countryData'] = countryDataObj
    pageState['searchResults'] = countryDataObj
  }

  setCountryData()
}

window.addEventListener('DOMContentLoaded', pageHandler)