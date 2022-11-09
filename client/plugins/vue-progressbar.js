import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'

const options = {
  color: 'red',
  failedColor: '#874b4b',
  thickness: '10px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'bottom',
  inverse: false
}

Vue.use(VueProgressBar, options)