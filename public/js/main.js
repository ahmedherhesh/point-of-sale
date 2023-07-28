function getParams() {
    let params = window.location.search.replace("?", "");
    let paramsObj = {};
    params = params.split("&");
    params.forEach((element) => {
        let el = element.split("=");
        paramsObj[el[0]] = el[1];
    });
    return paramsObj;
}

$(".delete-btn").on("click", function (e) {
    let result = confirm(`هل انت متأكد من حذف ${$(this).data("type")}`);
    if (!result) e.preventDefault();
});
//active button move
// $('body').on('click', '.nav-link', function () {
//     $('.nav-link').removeClass('ctm-btn')
//     $(this).addClass('ctm-btn')
// })
$('body').on('click', '.menu-btn', function () {
    $('.sidebar').toggleClass('translate-x-full')
})
$(window).on('resize', function () {
    if ($(window).width() < 640)
        $('.sidebar').css({ right: '-255px' })
    else
        $('.sidebar').css({ right: 0 })

})
$('body').on('click', '#dropdown-user-btn', function () {
    $('#dropdown-user').toggleClass('hidden').css({
        top: '57px',
        left: '7px'
    })
})
$(document).on('click', function (e) {
    if (!e.target.closest('.sidebar') && !e.target.closest('.menu-btn') && $(window).width() < 640) {
        $('.sidebar').css({ right: '-255px' })
    }
    if (!e.target.closest('#dropdown-user') && !e.target.closest('#dropdown-user-btn')) {
        $('#dropdown-user').addClass('hidden').removeClass('block')
    }
})

