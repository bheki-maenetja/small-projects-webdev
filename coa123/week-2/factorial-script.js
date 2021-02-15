function factorialCalc() {
  const num = Number(prompt('Enter your number:'))
  let result = 1
  // Task: Calculate factorial of num and store it in result variable
  function getFac(n) {
    if (n === 1) {
      return 1
    } else {
      return n * getFac(n - 1)
    }
  }
  result = getFac(num)
  // end of Task
  alert(result)
}

factorialCalc()