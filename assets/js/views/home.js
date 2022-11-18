const heroCarousel = document.querySelector(".hero-carousel");

const carouselItem1 = document.querySelector(
  ".hero-carousel__item:nth-child(1)"
);
const carouselItem2 = document.querySelector(
  ".hero-carousel__item:nth-child(2)"
);
const carouselItem3 = document.querySelector(
  ".hero-carousel__item:nth-child(3)"
);
const to1Button = document.querySelector("#to-1");
const to2Button = document.querySelector("#to-2");
const to3Button = document.querySelector("#to-3");

const carousel = new (class Carousel {
  wrapper = heroCarousel;
  carouselItems = [carouselItem1, carouselItem2, carouselItem3];
  buttons = [to1Button, to2Button, to3Button];
  initial = 0;
  mouseX1 = null;
  mouseX2 = null;

  attachListeners() {
    this.buttons.forEach((button, index) => {
      button?.addEventListener("click", () => {
        button.classList.add("active");
        this.buttons.forEach((btn, idx) => {
          if (idx !== index) {
            btn.classList.remove("active");
          }
        });
        this.to(index);
      });
    });

    this.wrapper?.addEventListener("touchstart", (e) => {
      this.mouseX1 = e.touches[0].clientX;
    });

    this.wrapper?.addEventListener("touchend", (e) => {
      this.mouseX2 = e.changedTouches[0].clientX;
      if (
        this.mouseX1 > this.mouseX2 &&
        Math.abs(this.mouseX1 - this.mouseX2) > 100
      ) {
        this.next();
      } else if (
        this.mouseX2 > this.mouseX1 &&
        Math.abs(this.mouseX1 - this.mouseX2) > 100
      ) {
        this.prev();
      }
    });
  }

  start() {
    setInterval(() => {
      this.next();
    }, 25000);
  }

  to(id) {
    const carouselItem = this.carouselItems[id];
    this.carouselItems.forEach((item) => {
      item.classList.remove("active");
    });
    carouselItem?.classList.add("active");
  }

  next() {
    this.initial = (this.initial + 1) % this.buttons.length;
    this.buttons[this.initial]?.click();
  }

  prev() {
    if (this.initial === 0) {
      this.initial = this.buttons.length - 1;
    } else {
      this.initial = this.initial - 1;
    }
    this.buttons[this.initial]?.click();
  }
})();

carousel.attachListeners();
carousel.start();
