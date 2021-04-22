/* eslint-disable indent */
function pageHandler() {
    const pageState = {
        countryData: null,
        searchResults: null,
        rankedData: null,
        rank_critereon: ['country_name', false],
        selected_countries: []
    }

  // DOM Variables
    const tableBody = document.querySelector('tbody')
    const rankCritereons = document.querySelectorAll('.rank-critereon')
    const countryInput = document.querySelector('#country-input')
    const countrySearchBtn = document.querySelector('#search-countries')
    const countrySelector = document.querySelector('#country-select')
    const addCountryBtn = document.querySelector('#add-country')
    const clearCountriesBtn = document.querySelector('#clear-countries')
    const compareCountriesBtn = document.querySelector('#compare-countries')
    const displayedCountries = document.querySelector('#displayed_countries')

  // Loading Data
    function setCountryData() {
        const countryData = sessionStorage.getItem('Data')
        const countryDataObj = JSON.parse(countryData)
        pageState['countryData'] = countryDataObj.map(elem => elem)
        pageState['rankedData'] = countryDataObj.map(elem => elem)

        var urlParams = new URLSearchParams(window.location.search)
        const firstCountry = urlParams.get('first_country')
        const secondCountry = urlParams.get('second_country')

        if (firstCountry && secondCountry) {
            pageState['searchResults'] = pageState['countryData'].filter(country => {
                return country.ISO_id === firstCountry || country.ISO_id === secondCountry
            })
            pageState['selected_countries'] = [firstCountry, secondCountry]
            clearCountriesBtn.style.display = 'block'
            compareCountriesBtn.style.display = 'block'
            renderSelectedCountries()
        } else {
            pageState['searchResults'] = countryDataObj.map(elem => elem)
        }
        rankSearchResults(pageState['rank_critereon'][0])
        sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
        renderSelector()
        renderTable()
    }

  // Sorting Functionality
    function sortHandler(e) {
        pageState['rank_critereon'][0] = e.target.dataset.value
        pageState['rank_critereon'][1] = !pageState['rank_critereon'][1]
        
        rankCritereons.forEach(elem => {
            elem.classList.remove('selected')
            elem.classList.remove('descending')
            elem.classList.remove('ascending')
        })

        e.target.classList.add('selected')

        if (pageState['rank_critereon'][1]) {
            e.target.classList.remove('ascending')
            e.target.classList.add('descending')
        } else {
            e.target.classList.remove('descending')
            e.target.classList.add('ascending')
        }

        rankSearchResults(pageState['rank_critereon'][0])
        sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
        renderTable()
    }

    function sortSearchResults(critereon, sortDsc = true) {
        var tempResults = pageState['searchResults']
        if (sortDsc) {
            if (critereon != 'country_name') {
                tempResults.sort((a, b) => {
                    return parseFloat(a[critereon]) < parseFloat(b[critereon]) ? 1 : -1
                })
            } else {
                tempResults.sort((a, b) => {
                    return a[critereon] < b[critereon] ? 1 : -1
                })
            }
        } else {
            if (critereon != 'country_name') {
                tempResults.sort((a, b) => {
                    return parseFloat(a[critereon]) > parseFloat(b[critereon]) ? 1 : -1
                })
            } else {
                tempResults.sort((a, b) => {
                    return a[critereon] > b[critereon] ? 1 : -1
                })
            }
        }
        pageState['searchResults'] = tempResults
    }

    function rankSearchResults(critereon) {
        var tempResults = pageState['countryData'].map(elem => elem)
        if (critereon != 'country_name') {
            if (critereon === 'avg_cyclist_age') {
                tempResults.sort((a, b) => {
                    return parseFloat(a[critereon]) >= parseFloat(b[critereon]) ? 1 : -1
                })
            } else {
                tempResults.sort((a, b) => {
                    return parseFloat(a[critereon]) <= parseFloat(b[critereon]) ? 1 : -1
                })
            }
        } else {
            tempResults.sort((a, b) => {
                return a[critereon] > b[critereon] ? 1 : -1
            })
        }
        pageState['rankedData'] = tempResults
    }
  // Searching Functionality
    function validateInput(e) {
        var inputString = e.target.value.trim().toLowerCase()
        inputString.split('').forEach(char => {
            if (!char.match('[a-z]')) {
                inputString = inputString.replace(char, '')
            }
        })
        e.target.value = inputString.toUpperCase()
        clearSelection()
        searchHandler()
        rankSearchResults(pageState['rank_critereon'][0])
        sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
        renderTable()
    }

    function searchHandler() {
        const searchString = countryInput.value
        if (searchString === '') {
            pageState['searchResults'] = pageState['countryData'].map(elem => elem)
        } else {
            pageState['searchResults'] = pageState['countryData'].filter(country => {
                return country.ISO_id.includes(searchString)
            })
        }
    }

    function selectHandler(e) {
        e.preventDefault()
        countryInput.value = ''
        const isoId = countrySelector.value

        if (clearCountriesBtn.style.display != 'block') {
            clearCountriesBtn.style.display = 'block'
        }

        if (isoId != '') {
            pageState['selected_countries'].push(isoId)
            pageState['searchResults'] = pageState['countryData'].filter(country => {
                return pageState['selected_countries'].includes(country.ISO_id)
            })
            rankSearchResults(pageState['rank_critereon'][0])
            sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])

            if (pageState['selected_countries'].length == 2) {
                compareCountriesBtn.style.display = 'block'
            } else {
                compareCountriesBtn.style.display = 'none'
            }
            renderSelector()
            renderSelectedCountries()
            renderTable()
        }
        console.log(pageState['selected_countries'])
    }

    function clearSelection(e = null) {
        pageState['selected_countries'] = []
        clearCountriesBtn.style.display = 'none'
        compareCountriesBtn.style.display = 'none'
        renderSelector()
        renderSelectedCountries()
        if (e) {
            e.preventDefault()
            countryInput.value = ''
            pageState['searchResults'] = pageState['countryData'].map(elem => elem)
            rankSearchResults(pageState['rank_critereon'][0])
            sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
            renderTable()
        }
    }

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
                            <td>${pageState['rankedData'].indexOf(country) + 1}</td>
                            <td>${country.country_name} (${country.ISO_id})</td>
                            <td>${country.num_cyclists}</td>
                            <td>${country.avg_cyclist_age === 1000 ? 'n/a' : country.avg_cyclist_age.toFixed(1)}</td>
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

    function renderSelector() {
        countrySelector.innerHTML = `
            <option value="" selected>Select a Country</option>
            ${pageState['countryData'].map(country => {
                if (!pageState['selected_countries'].includes(country.ISO_id)) {
                    return `<option value="${country.ISO_id}">${country.country_name}</option>`
                } else {
                    return ''
                }
            })}
        `
    }

    function renderSelectedCountries() {
        if (pageState['selected_countries'].length > 0) {
            displayedCountries.innerHTML = `Displaying: ${pageState['selected_countries'].join(', ')}`
        } else {
            displayedCountries.innerHTML = ''
        }
    }

  // Page Transition
    function pageTransition(e) {
        e.preventDefault()
        var urlParams = new URLSearchParams()
        urlParams.append('first_country', pageState['selected_countries'][0])
        urlParams.append('second_country', pageState['selected_countries'][1])
        window.open(`country-compare.html?${urlParams.toString()}` , '_self')
    }

  // DOM Object Event Listeners
    rankCritereons.forEach(th => {
        th.addEventListener('click', sortHandler)
    })

    countryInput.addEventListener('input', validateInput)
    countrySearchBtn.addEventListener('click', (e) => e.preventDefault())
    addCountryBtn.addEventListener('click', selectHandler)
    clearCountriesBtn.addEventListener('click', clearSelection)
    compareCountriesBtn.addEventListener('click', pageTransition)

    setCountryData()
}

window.addEventListener('DOMContentLoaded', pageHandler)