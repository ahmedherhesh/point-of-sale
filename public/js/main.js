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

$('body').on('click', '.menu-btn', function () {
    $('.sidebar').toggleClass('translate-x-full')
})
$(window).on('resize', function () {
    $('.sidebar').addClass('translate-x-full')
})
let dropdownUser = $('#dropdown-user');
$('body').on('click', '#dropdown-user-btn', function () {
    $('#dropdown-user').toggleClass('hidden').css({
        top: '56px',
        left: '7px'
    })
})
$(document).on('click', function (e) {
    if (!e.target.closest('.sidebar') && !e.target.closest('.menu-btn') && $(window).width() < 640) {
        sidebar.addClass('translate-x-full')
    } else if (!e.target.closest('#dropdown-user') && !e.target.closest('#dropdown-user-btn')) {
        dropdownUser.addClass('hidden').removeClass('block')
    }
})

