function getAverage() {
  const numArr = [
    Number(prompt('Enter your 1st number:')),
    Number(prompt('Enter your 2nd number:')),
    Number(prompt('Enter your 3rd number:'))
  ]

  if (numArr.some(elem => elem < 40)) {
    return 'Fail'
  } else {
    return 'Pass'
  }
}

alert(`Verdict: ${getAverage()}`)