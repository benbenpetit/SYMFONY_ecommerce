import './styles/style.scss';
// import modularLoad from 'modularload';
import LocomotiveScroll from 'locomotive-scroll';
// import barba from '@barba/core';

// barba.init({
//   transitions: [{
//     name: 'default-transition',
//     leave() {
//       console.log('in')
//     },
//     enter() {
//       console.log('out')
//     }
//   }]
// });

let scroll = new LocomotiveScroll({
  el: document.querySelector('[data-scroll-container]'),
  smooth: true,
  multiplier: 1,
  lerp: 0.12
});

// const load = new modularLoad({
//   enterDelay: 900,
// });

// load.on('loaded', () => {
//   scroll.destroy();
//   scroll = new LocomotiveScroll({
//     el: document.querySelector('[data-scroll-container]'),
//     smooth: true,
//     multiplier: 1,
//     lerp: 0.12
//   });
// });
