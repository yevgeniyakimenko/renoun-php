/* const saturationSlider = document.querySelector('#saturation')
const saturationValueSpan = document.querySelector('#sat-value')
saturationValueSpan.innerHTML = saturationSlider.value
saturationSlider.addEventListener('input', (event) => {
  saturationValueSpan.innerHTML = saturationSlider.value
}) */

/* const brightnessSlider1 = document.querySelector('#brightness1')
const brightnessSlider2 = document.querySelector('#brightness2')
const brightnessValueSpan = document.querySelector('#bright-value')
brightnessValueSpan.innerHTML = brightnessRangeString()
brightnessSlider1.addEventListener('input', (event) => {
  brightnessValueSpan.innerHTML = brightnessRangeString()
})
brightnessSlider2.addEventListener('input', (event) => {
  brightnessValueSpan.innerHTML = brightnessRangeString()
}) */

/* function brightnessRangeString() {
  const maxValue = Math.max(brightnessSlider1.value, brightnessSlider2.value)
  const minValue = Math.min(brightnessSlider1.value, brightnessSlider2.value)
  return `${minValue} - ${maxValue}`
} */

/* const resetButton = document.querySelector('#reset-form')
resetButton.addEventListener('click', (event) => {
  event.preventDefault()
  saturationSlider.value = 75
  brightnessSlider1.value = 0
  brightnessSlider2.value = 95
  saturationValueSpan.innerHTML = saturationSlider.value
  brightnessValueSpan.innerHTML = brightnessRangeString()
}) */

const hueRange = document.querySelector('#hue')
// console.log('hueRange', hueRange)
const hueBox = document.querySelector('.hue-box')
hueBox.style.backgroundColor = `hsl(${hueRange.value}, 100%, 60%)`
hueRange.addEventListener('input', (event) => {
  hueBox.style.backgroundColor = `hsl(${hueRange.value}, 100%, 60%)`
})