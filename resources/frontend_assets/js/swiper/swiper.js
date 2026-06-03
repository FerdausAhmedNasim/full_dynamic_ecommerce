// let swiper = new Swiper(".heroSwiper", {
//     slidesPerView: 1,
//     spaceBetween: 30,
//     pagination: {
//       el: ".swiper-pagination",
//       clickable: true,
//     },
//   });

let swiper = new Swiper(".heroSwiper", {
    slidesPerView: 1,
    effect: 'fade',
    spaceBetween: 30,
    speed: 2000,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
});

let topBrandSwiper = new Swiper(".topBrandSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    speed: 400,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
});

let dealsSwiper = new Swiper(".dealsSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    speed: 400,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

let page = window.innerWidth;

var brandSwiper = new Swiper(".brandSwiper", {
    slidesPerView: page > 1400 ? 8 : page > 1200 ? 7 : page > 993 ? 5 : page > 668 ? 3 : 2,
    spaceBetween: 15,
    speed: 400,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false
    },
    navigation: {
        nextEl: '.brand-next',
        prevEl: '.brand-prev',
      }
  });

  const deals = new Swiper('.mySwiper', {
    slidesPerView: 3,
    loop: true,
    speed: 1000,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    spaceBetween: 20,
    on: {
        slideChangeTransitionStart: function () {
            const slides = document.querySelectorAll('.deals .swiper-slide');
            slides.forEach(slide => slide.classList.remove('active', 'blur'));
            const activeSlide = slides[deals.activeIndex];
            activeSlide.classList.add('active');
            slides.forEach(slide => {
                if (!slide.classList.contains('active')) slide.classList.add('blur');
            });
        },
    },
});

// Initial setup
const initialSlides = document.querySelectorAll('.deals .swiper-slide');
initialSlides.forEach(slide => slide.classList.add('blur'));
initialSlides[deals.activeIndex].classList.add('active');
