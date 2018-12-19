$(document).ready(function () {
    $.support.transition = false;

    $('#canvas').bcPaint();

    $('form').one('submit', function (e) {
        e.preventDefault();
        $.fn.bcPaint.export();
        $(this).submit();
    })
});