jQuery(document).on('ready', function() {
    jQuery('.responsive').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
});
jQuery(function() {
    jQuery('#itemslider').carousel({
        interval: 3000
    });
}());
(function() {
    jQuery('.carousel-showmanymoveone .item').each(function() {
        var itemToClone = jQuery(this);
        for (var i = 1; i < 5; i++) {
            itemToClone = itemToClone.next();
            if (!itemToClone.length) {
                itemToClone = jQuery(this).siblings(':first');
            }
            itemToClone.children(':first-child').clone().addClass("cloneditem-" + (i)).appendTo(jQuery(this));
        }
    });
}());
jQuery(document).ready(function() {
    jQuery('#contact_form form').validate({
        rules: {
            exampleInputName: {
                required: true,
                minlength: 10
            },
            exampleInputEmail: {
                required: true,
                email: true
            },
            exampleInputPhone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 14,
            },
            exampleInputContent: {
                required: true,
            },
        },
        messages: {
            exampleInputName: {
                required: "Họ và tên không được để trống",
                minlength: "Tên nhập không được ít hơn 10 ký tự",
            },
            exampleInputEmail: {
                required: "Email không được để trống",
                email: "Địa chỉ email không đúng định dạng ví du:name@domain.com"
            },
            exampleInputPhone: {
                required: "Số điện thoại không được để trống",
                number: "Không đúng định dạng",
                minlength: "Số nhập không được ít hơn 10",
                minlength: "Số nhập không được nhiều hơn 14"
            },
            exampleInputContent: {
                required: "Nội dung không được để trống",
            },
        },
        submitHandler: function(form) {
            form.submit();
            // var data = jQuery(form).serializeObject();
            // console.log(data);
            // jQuery.post("post.php", data, function(e) {
            //     alert("Bạn gửi tin thành công")
            // })
        },
        highlight: function(element) {
            jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element) {
            jQuery(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        validClass: 'has-success',
        success: function(label, input) {
            jQuery(input).closest('.form-group').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});
jQuery(document).ready(function() {
    jQuery(".mega_menu").addClass("intro");
    jQuery(".intro").click(function() {
        jQuery(".menu ul").toggleClass('toggle');
    });
});
jQuery(document).ready(function() {
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 200) {
            jQuery('.scrollup').fadeIn(200);
        } else {
            jQuery('.scrollup').fadeOut(200);
        }
    });
    jQuery('.scrollup').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, 300);
    })
});
jQuery(window).scroll(function() {
    var scroll = jQuery(this).scrollTop();
    var footer = jQuery('footer').offset().top;
    if (scroll >= 100) {
        jQuery(".hotline_footer").addClass("fixed");
        jQuery("#footer_fix_1").addClass("footer_fix_1");
        jQuery("#footer_fix_1").css('display', 'block');
        jQuery(".footer_fix").css({
            'border-right': '1px solid #fff',
            'width': '50%',
            "padding": " 10px 0px"
        });
        jQuery(".chat").addClass("fixed_chat");
        jQuery(".hotline_footer h1").css('padding', '0');
        jQuery(".hotline_footer").css("height", '43px');
    }
    if (scroll > footer - 600) {
        jQuery(".hotline_footer").removeClass("fixed");
        jQuery(".hotline_footer").css("height", '64px');
        jQuery("#footer_fix_1").removeClass("footer_fix_1");
        jQuery("#footer_fix_1").css('display', 'none');
        jQuery(".footer_fix").css({
            'border-right': '0',
            'width': '100%',
            'padding': '18px'
        });
        jQuery(".chat").removeClass("fixed_chat");
        jQuery(".hotline_footer h1").css('padding', '18px');
    }
});