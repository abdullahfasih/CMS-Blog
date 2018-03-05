tinymce.init({selector: 'textarea'});

$(document).ready(function () {

//    check all post
    $("#checkAllBoxes").click(function (e) {
        if (this.checked) {
            $(".checkBoxes").each(function () {
                this.checked = true;
            });
        } else {
            $(".checkBoxes").each(function () {
                this.checked = false;
            });
        }
    });

//    page loader
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";

    $("body").prepend(div_box);

    $("#load-screen").delay(500).fadeOut(200, function () {
        $(this).remove();
    });


});

