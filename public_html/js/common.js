$(function () {
    $("form[name='registration']").validate({
        rules: {
            first_name: {
                //lettersonly: true,
                required: true,
                minlength: 3,
                maxlength: 15
            },
            last_name: {
                //	lettersonly: true,
                required: true,
                minlength: 3,
                maxlength: 15
            },
            email: {
                required: true,
                email: true
            },
            contact_number: {
                number: true,
                required: true,
                minlength: 10,
                maxlength: 10
            },
            date_of_birth: {
                required: true
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                minlength: "Your first name must be at least 3 characters long",
                maxlength: "Your first name must be less then 15 characters"

            },
            last_name: {
                required: "Please enter your last name",
                minlength: "Your last name must be at least 3 characters long",
                maxlength: "Your last name must be less then 15 characters"

            },
            contact_number: {
                number: "Please enter only numbers",
                required: "Please provide a contact number",
                minlength: "Your contact number must be at least 10 characters long"
            },
            email: "Please enter a valid email address",
            date_of_birth: "Please select date of birth"
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: APP_BASE_URL + "/student/create",
                data: $("form").serializeArray(),
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                async: false,
                success: function (data) {
                    $(".your_favorite_div").append(data);
                },
                error: function () {
                    alert("chyba");
                }
            });
        }
    });



    $("div.success").fadeIn(300).delay(1500).fadeOut(400);
});

$(document).ready(function () {
    load_data();
    function load_data(page)
    {
        $.ajax({
            url: APP_BASE_URL + "/student/list",
            method: "GET",
            data: {page: page},
            success: function (data) {
                $('#pagination_data').html(data);
            }
        })
    }
    $(document).on('click', '.pagination_link', function () {
        var page = $(this).attr("id");
        load_data(page);
    });
});
  