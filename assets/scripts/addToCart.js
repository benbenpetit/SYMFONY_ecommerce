const addButton = document.querySelector(".js-add-cart");
const validationWrapper = document.querySelector(".validation-wrapper");

addButton.addEventListener("click", () => {
  const id = addButton.getAttribute("data-id");
  addButton.setAttribute("disabled", true);

  fetch(`/cart/add/${id}`, {
    method: "POST"
  })
  .then((response) => {
    if (response.ok) {
      validationWrapper.classList.add("article-added");
      
      setTimeout(() => {
        validationWrapper.classList.remove("article-added");
      }, 1500);
    } else {
      addButton.removeAttribute("disabled");
      console.log('Une erreur est survenue');
    }

    addButton.removeAttribute("disabled");
  })
  .catch((error) => {
    addButton.removeAttribute("disabled");
    console.log(error);
  });
});
