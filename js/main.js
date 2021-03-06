$(document).ready(function() {
    const hotelSlider = new Swiper(".hotel-slider", {
        // Optional parameters
        loop: true,

        // Navigation arrows
        navigation: {
            nextEl: ".hotel-slider__button--next",
            prevEl: ".hotel-slider__button--prev",
        },
    });

    const reviewsSlider = new Swiper(".reviews-slider", {
        // Optional parameters
        loop: true,

        // Navigation arrows
        navigation: {
            nextEl: ".reviews-slider__button--next",
            prevEl: ".reviews-slider__button--prev",
        },
    });

    var menuButton = document.querySelector(".menu-button");
    menuButton.addEventListener("click", function() {
        document.querySelector('.navbar-bottom').classList.toggle('navbar-bottom--visible');
    });

    function openModal() {
        var modalOverlay = $(".modal__overlay");
        var modalDialog = $(".modal__dialog");
        modalOverlay.addClass("modal__overlay--visible");
        modalDialog.addClass("modal__dialog--visible");
    }

    function closeModal(event) {
        var modalOverlay = $(".modal__overlay");
        var modalDialog = $(".modal__dialog");
        event.preventDefault();
        modalOverlay.removeClass("modal__overlay--visible");
        modalDialog.removeClass("modal__dialog--visible");
    }

    var modalButton = $("[data-toggle=modal]");
    var closeModalButton = $(".modal__close");
    modalButton.on('click', openModal);
    closeModalButton.on('click', closeModal);

    // each - для каждой формы с классом form запустить функцию проверки ИМЕННО ЭТОЙ формы
    $(".form").each(function() {
        $(this).validate({
            errorClass: "invalid",
            messages: {
                name: {
                    required: "Please enter your name.",
                    minlength: "The name must be at least 2 characters long.",
                },
                email: {
                    required: "Please enter your e-mail.",
                    email: "Your email address must be in the format of name@domail.com.",
                },
                phone: {
                    required: "Please enter your phone.",
                    minlength: "Phone mask: +7 (999) 99 99",
                },
                message: {
                    minlength: "The message must be at least 10 characters long.",
                }
            },
        }); // validate
    }); // function

    $('.phone').mask('+7 (999) 99 99');

    AOS.init();

}); // jQuery