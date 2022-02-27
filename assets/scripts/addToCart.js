import axios from "axios";

const addButton = document.querySelector(".js-add-cart");
const validationWrapper = document.querySelector(".validation-wrapper");

addButton.addEventListener("click", () => {
  const id = addButton.getAttribute("data-id");
  addButton.setAttribute('disabled', true);

  axios
    .post(`/cart/add/${id}`)
    .then(function (response) {
      validationWrapper.classList.add('article-added');
      setTimeout(() => {
        validationWrapper.classList.remove('article-added');
        addButton.removeAttribute('disabled');
      }, 2000);
    })
    .catch(function (error) {
      console.log(error);
    });
});
