// -------------------------Page Loader
$(window).on("load", function () {
  setTimeout(function () {
    $(".loader").fadeOut();
    $(".loader-mask").fadeOut("slow");
  }, 1000);
});
// -------------------------cursor animation
$(window).on("mousemove", function (e) {
  $(".ring").css(
    "transform",
    `translateX(calc(${e.clientX}px - 1.25rem)) translateY(calc(${e.clientY}px - 1.25rem))`
  );
});
//------------------------- header active on scroll down to 100px
$(document).ready(function () {
  const $header = $("[data-header]");
  $(window).on("scroll", function () {
    const scrollTop = parseInt($(this).scrollTop(), 10);
    if (scrollTop > 50) {
      $header.addClass("active");
    } else {
      $header.removeClass("active");
    }
  });
});
// -------------------------Header navbar
$(document).ready(function () {
  $(".menu-option").on("click", function () {
    $(".menu-option").hide();
    $(".close-menu").show();
    $(".main-header-menu").addClass("open");
  });
  $(".close-menu").on("click", function () {
    $(".close-menu").hide();
    $(".menu-option").show();
    $(".main-header-menu").removeClass("open");
  });
});
// ------------------------- active header
$(document).ready(function () {
  const activeTab = localStorage.getItem("activeTab");
  if (activeTab) {
    $(`[data-tab="${activeTab}"]`).addClass("active");
  }
  // Use proper event binding with delegation
  $(document).on("click", ".tabs-li", function () {
    $(".tabs-li").removeClass("active");
    $(this).addClass("active");
    const tabValue = $(this).data("tab");
    localStorage.setItem("activeTab", tabValue);
  });
  if (window.location.pathname.includes("index.html")) {
    $(".tabs-li").removeClass("active");
    localStorage.removeItem("activeTab");
  }
});
// animation
$(document).ready(function () {
  setTimeout(() => {
    gsap.to(".animate-section", {
      opacity: 1,
      y: 0,
      duration: 1.5,
      ease: "power2.out",
      stagger: 0.5,
    });
    gsap.to(".animate-section-very", {
      opacity: 1,
      y: 0,
      duration: 1.5,
      ease: "power2.out",
      stagger: 0.5,
    });
  }, 1000);
});
// ------------------------- blur effect responsive
$(document).ready(function () {
  $(document).on("click", ".menu-option", function () {
    $(".blury").addClass("backky");
  });
  $(document).on("click", ".close-menu", function () {
    $(".blury").removeClass("backky");
  });
});
// -------------------------Type word animation
window.onload = function () {
  const txt = ["Web Developer", "Web Designer", "UI/UX Designer"];
  let i = 0,
    j = 0;
  let end = false;
  function wait(seconds) {
    return new Promise((resolve) => setTimeout(resolve, seconds * 500));
  }
  async function main() {
    const typedElement = document.getElementById("typed");
    if (!typedElement) return;
    if (i < txt.length) {
      if (end === false && j <= txt[i].length) {
        typedElement.innerHTML += txt[i][j];
        j++;
      }
      if (end === true && j <= txt[i].length) {
        typedElement.innerHTML = txt[i].substring(0, j - 1);
        j--;
      }
      if (j === txt[i].length) {
        end = true;
        await wait(2);
      }
      if (end === true && j === 0) {
        i++;
        end = false;
      }
    } else {
      i = 0;
    }
    setTimeout(main, 200);
  }
  main();
};
// ----------------------------Number counter
$(document).ready(function () {
  let a = 0;
  $(document).on("scroll", function () {
    let $counter = $("#counter");
    if ($counter.length) {
      let oTop = $counter.offset().top - window.innerHeight;
      if (a === 0 && $(window).scrollTop() > oTop) {
        $(".counter").each(function () {
          let $this = $(this);
          jQuery({ Counter: 0 }).animate(
            { Counter: parseInt($this.text(), 10) },
            {
              duration: 2000,
              easing: "swing",
              step: function () {
                $this.text(Math.ceil(this.Counter));
              },
            }
          );
        });
        a = 1;
      }
    }
  });
});
// ----------------------------slider
$(document).ready(function () {
  $(".autoplay").slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: true,
    arrows: false,
    dots: true,
    speed: 1000,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
          arrows: false,
        },
      },
    ],
  });
});
