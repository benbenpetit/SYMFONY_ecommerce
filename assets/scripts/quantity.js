const minusButtons = document.querySelectorAll('.js-quantity-button.-minus');
const plusButtons = document.querySelectorAll('.js-quantity-button.-plus');

const getClosestId = (btn) => btn.closest('.js-item').getAttribute('data-item-id');

minusButtons.forEach(minusButton => {
  const id = getClosestId(minusButton);

  minusButton.addEventListener('click', () => {
    fetch(`/cart/subtract/${id}`, {
      method: "POST"
    })
    .then((response) => {
      if (response.ok) {
        location.reload();
      } else {
        console.log('Une erreur est survenue');
      }
    })
    .catch((error) => {
      console.log(error);
    });
  });
});

plusButtons.forEach(plusButton => {
  const id = getClosestId(plusButton);

  plusButton.addEventListener('click', () => {
    fetch(`/cart/add/${id}`, {
      method: "POST"
    })
    .then((response) => {
      if (response.ok) {
        location.reload();
      } else {
        console.log('Une erreur est survenue');
      }
    })
    .catch((error) => {
      console.log(error);
    });
  });
})
