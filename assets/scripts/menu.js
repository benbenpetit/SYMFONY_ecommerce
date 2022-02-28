const profileButton = document.querySelector('.js-profile-icon');
const profileModal = document.querySelector('.js-profile-modal');

document.addEventListener('click', (e) => {
  if (e.target.closest('.js-profile-icon')) {
    profileModal.classList.toggle('is-visible');
  } else {
    if (!e.target.closest('.js-profile-modal')) {
      profileModal.classList.remove('is-visible');
    }
  }
  console.log('in');
});
