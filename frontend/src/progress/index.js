import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'

const options = {
  color: '#5100DE',
  failedColor: 'rgb(242, 19, 93)',
  thickness: '3px',
  transition: {
    speed: '1.5s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options)
