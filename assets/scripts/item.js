import axios from "axios";

const product = document.querySelector(".product");

product.addEventListener("click", (e) => {
  e.preventDefault();
  const id = product.getAttribute("data-id");

  axios
    .post(`/cart/add/${id}`, {
      id: id
    })
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
});
