/* eslint-disable indent */
function pageHandler() {
  console.log('Let\'s go!!!')

  const pageState = {
    countryData: null,
    searchResults: null,
    rank_critereon: ['country_name', false]
  }

  // DOM Variables
  const tableBody = document.querySelector('tbody')
  const rankCritereons = document.querySelectorAll('.rank-critereon')

  // Loading Data
  function setCountryData() {
    const countryData = sessionStorage.getItem('Data')
    const countryDataObj = JSON.parse(countryData)
    pageState['countryData'] = countryDataObj
    pageState['searchResults'] = countryDataObj
    sortSearchResults(pageState['rank_critereon'][0], pageState['rank_critereon'][1])
    // rankSearchResults()
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
    // rankSearchResults()
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

  // DOM Object Event Listeners
  rankCritereons.forEach(th => {
      th.addEventListener('click', sortHandler)
  })
}

window.addEventListener('DOMContentLoaded', pageHandler)