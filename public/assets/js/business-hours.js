$(document).ready(function () {
    $(".open_time").timeDropper({
        format:"HH:mm",
        setCurrentTime: false,
    });
    $(".close_time").timeDropper({
        format:"HH:mm",
        setCurrentTime: false,
    })
    $('select.is_holi').on('change', function () {
        console.log($(this).val());
        if (($(this).val() == 1) && $(this).hasClass('is_sat_holi')) {
            $('#open_sat').slideUp();
            $('#close_sat').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_sat_holi')) {
            $('#open_sat').slideDown();
            $('#close_sat').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_sun_holi')) {
            $('#open_sun').slideUp();
            $('#close_sun').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_sun_holi')) {
            $('#open_sun').slideDown();
            $('#close_sun').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_mon_holi')) {
            $('#open_mon').slideUp();
            $('#close_mon').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_mon_holi')) {
            $('#open_mon').slideDown();
            $('#close_mon').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_tue_holi')) {
            $('#open_tue').slideUp();
            $('#close_tue').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_tue_holi')) {
            $('#open_tue').slideDown();
            $('#close_tue').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_wed_holi')) {
            $('#open_wed').slideUp();
            $('#close_wed').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_wed_holi')) {
            $('#open_wed').slideDown();
            $('#close_wed').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_thu_holi')) {
            $('#open_thu').slideUp();
            $('#close_thu').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_thu_holi')) {
            $('#open_thu').slideDown();
            $('#close_thu').slideDown();
        } else if (($(this).val() == 1) && $(this).hasClass('is_fri_holi')) {
            $('#open_fri').slideUp();
            $('#close_fri').slideUp();
        } else if (($(this).val() == 0) && $(this).hasClass('is_fri_holi')) {
            $('#open_fri').slideDown();
            $('#close_fri').slideDown();
        }
    });
});