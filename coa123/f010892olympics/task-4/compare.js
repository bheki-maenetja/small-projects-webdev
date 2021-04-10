
function pageSetup () {

  function getData() {
    var httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var dataObj = JSON.parse(this.response)
        console.log(typeof(dataObj))
        console.log(dataObj)
      } else {
        console.log('SOMETHING IS WRONG')
      }
    }
    httpRequest.open('GET', 'get_data.php', true)
    httpRequest.send()
  }
  
}

window.addEventListener('DOMContentLoaded', pageSetup)