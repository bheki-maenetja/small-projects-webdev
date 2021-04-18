/* eslint-disable indent */
function pageHandler() {
    console.log('Let\'s go!!!')

    const pageState = {
        countryData: null,
        searchResults: null,
        rank_critereon: ['country_name', false],
        selected_countries: []
    }

  // DOM Variables
    const tableBody = document.querySelector('tbody')
    const rankCritereons = document.querySelectorAll('.rank-critereon')
    const countryInput = document.querySelector('#country-input')
    const countrySelector = document.querySelector('#country-select')
    const addCountryBtn = document.querySelector('#add-country')
    const displayedCountries = document.querySelector('#displayed_countries')

  // Loading Data
    function setCountryData() {
        const countryData = sessionStorage.getItem('Data')
        const countryDataObj = JSON.parse(countryData)
        pageState['countryData'] = countryDataObj.map(elem => elem)
        pageState['searchResults'] = countryDataObj.map(elem => elem)
        sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
        renderSelector()
        renderTable()
    }

    setCountryData()

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

        sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
        renderTable()
    }

    function sortSearchResults(critereon, sortDsc = true) {
        var tempResults = pageState['searchResults']
        if (sortDsc) {
            if (critereon != 'country_name') {
                tempResults.sort((a, b) => {
                    return parseInt(a[critereon]) < parseInt(b[critereon]) ? 1 : -1
                })
            } else {
                tempResults.sort((a, b) => {
                    return a[critereon] < b[critereon] ? 1 : -1
                })
            }
        } else {
            if (critereon != 'country_name') {
                tempResults.sort((a, b) => {
                    return parseInt(a[critereon]) > parseInt(b[critereon]) ? 1 : -1
                })
            } else {
                tempResults.sort((a, b) => {
                    return a[critereon] > b[critereon] ? 1 : -1
                })
            }
        }
        pageState['searchResults'] = tempResults
    }

//   function rankSearchResults() {
//     var sortedCountryData = sortSearchResults(pageState['countryData'], pageState['rank_critereon'][0])
//     pageState['searchResults'].map(country => {
//         country['overall_rank'] = sortedCountryData.indexOf(country) + 1
//     })
//     console.log(pageState)
//   }
  // Searching Functionality
    function validateInput(e) {
        var inputString = e.target.value.trim().toLowerCase()
        inputString.split('').forEach(char => {
        if (!char.match('[a-z]')) {
            inputString = inputString.replace(char, '')
        }
        })
        e.target.value = inputString.toUpperCase()
        searchHandler()
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
        const isoId = countrySelector.value
        if (isoId != '') {
            pageState['selected_countries'].push(isoId)
            pageState['searchResults'] = pageState['countryData'].filter(country => {
                return pageState['selected_countries'].includes(country.ISO_id)
            })
            sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
            renderSelector()
            renderSelectedCountries()
            renderTable()
        }
        console.log(pageState['selected_countries'])
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
                            <td>#</td>
                            <td>${index + 1}</td>
                            <td>${country.country_name} (${country.ISO_id})</td>
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
        displayedCountries.innerHTML = `Displaying: ${pageState['selected_countries'].join(', ')}`
    }

  // DOM Object Event Listeners
    rankCritereons.forEach(th => {
        th.addEventListener('click', sortHandler)
    })

    countryInput.addEventListener('input', validateInput)
    addCountryBtn.addEventListener('click', selectHandler)

}

window.addEventListener('DOMContentLoaded', pageHandler)