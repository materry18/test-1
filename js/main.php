<?php

document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".stats__number");
    const options = {
      root: null,
      threshold: 0.5,
    };
  
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const target = entry.target;
          const maxVal = parseFloat(target.getAttribute("data-target"));
          const decimals = parseInt(target.getAttribute("data-decimal")) || 0;
          animateCount(target, maxVal, decimals);
          observer.unobserve(target);
        }
      });
    }, options);
  
    counters.forEach((counter) => observer.observe(counter));
  
    function animateCount(element, target, decimals) {
      let start = 0;
      const duration = 2000;
      const stepTime = 10;
      const step = target / (duration / stepTime);
  
      const timer = setInterval(() => {
        start += step;
        if (start >= target) {
          start = target;
          clearInterval(timer);
        }
        element.textContent = formatNumber(start, decimals);
      }, stepTime);
    }
  
    function formatNumber(number, decimals) {
      const fixedNumber = number.toFixed(decimals);
      return decimals === 0
        ? Number(fixedNumber).toLocaleString()
        : fixedNumber.replace(".", ",");
    }
  
    const swiper = new Swiper(".swiper", {
      // Optional parameters
      direction: "horizontal",
      loop: true,
      slidesPerView: 1,
      spaceBetween: 10,
      // Responsive breakpoints
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        // when window width is >= 640px
        768: {
          slidesPerView: 6,
          spaceBetween: 40,
        },
      },
  
      // If we need pagination
      pagination: {
        el: ".swiper-pagination",
      },
  
      // Navigation arrows
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
  
      // And if we need scrollbar
      scrollbar: {
        el: ".swiper-scrollbar",
      },
    });
    const slider = document.getElementById("slider");
    const sliderValue = document.getElementById("sliderValue");
    const moneyElements = document.querySelectorAll(".money");
    const rateElements = document.querySelectorAll(".rate");
    const totalElement = document.getElementById("total");
  
    function getThumbWidth() {
      return window.innerWidth > 768 ? 94 : 48;
    }
  
    function updateValues() {
      const sliderAmount = parseFloat(slider.value);
      sliderValue.textContent = sliderAmount + "€";
  
      const percentage =
        ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
  
      const thumbWidth = getThumbWidth();
      const correction = thumbWidth * (percentage / 100);
      sliderValue.style.left = `calc(${percentage}% - ${correction}px)`;
  
      let totalSum = 0;
  
      rateElements.forEach((rateEl, index) => {
        const rate = parseFloat(rateEl.dataset.rate);
        const result = sliderAmount * rate;
        moneyElements[index].textContent = result.toFixed(2) + "€";
        totalSum += result;
      });
  
      totalElement.textContent = totalSum.toFixed(2) + "€";
    }
  
    slider.addEventListener("input", updateValues);
    window.addEventListener("resize", updateValues);
  
    updateValues();
  
    const accordions = document.querySelectorAll(".accordion");
  
    accordions.forEach((accordion) => {
      accordion.addEventListener("click", function () {
        accordions.forEach((otherAccordion) => {
          if (otherAccordion !== accordion) {
            otherAccordion.classList.remove("active");
            const otherPanel = otherAccordion.nextElementSibling;
            otherPanel.classList.remove("show");
            otherPanel.style.maxHeight = "25px";
          }
        });
  
        const panel = this.nextElementSibling;
        panel.classList.toggle("show");
        this.classList.toggle("active");
  
        if (panel.classList.contains("show")) {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } else {
          panel.style.maxHeight = "20px";
        }
      });
    });
  
    for (let link of [...document.querySelectorAll('a')]) {
      link.addEventListener('click', (e) => {
          e.preventDefault()
          const href = e.target.getAttribute('href')
          if (!href) return
          const section = document.getElementById(href.slice(1))
          if (!section) return
          section.scrollIntoView({
              block: "start", behavior: "smooth"
          })
      })
  }
  });
    
        
  
?>