const carouselItems = Array.from(
  document.querySelectorAll(".hero-carousel__item")
);

const nextButton = document.querySelector("#carousel-next");
const previousButton = document.querySelector("#carousel-prev");

function toNextItem() {
  console.log("Clicked next button");
  carouselItems.forEach((item, index) => {
    console.log(item, item.classList.contains("active"));
    if (item.classList.contains("active")) {
      item.classList.remove("active");
      carouselItems[index + 1].classList.add("active");
    }
  });
}

function toPreviousItem() {
  console.log("clicked prev button");
  carouselItems.forEach((item, index) => {
    console.log(item, item.classList.contains("active"));
    if (item.classList.contains("active")) {
      item.classList.remove("active");
      carouselItems[index - 1].classList.add("active");
    }
  });
}

nextButton?.addEventListener("click", toNextItem);
previousButton?.addEventListener("click", toPreviousItem);
