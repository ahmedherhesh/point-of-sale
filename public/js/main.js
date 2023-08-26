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

const toggleSidebar = () => {
    let sidebar = $('.sidebar');
    let content = $('.content');
    if ($(window).width() < 640) {
        sidebar.css({ right: '-255px' });
        content.css('width', '100%')
    }
    else {
        sidebar.css({ right: '0px' });
        content.css('width', `calc(100% - 255px)`)
    }
}
$('body').on('click', '.menu-btn', function () {
    let sidebar = $('.sidebar');
    let content = $('.content');
    if (sidebar.css('right') == '0px') {
        sidebar.css({ right: '-255px' });
        content.css('width', '100%')
    }
    else {
        sidebar.css({ right: '0px' });
        content.css('width', `calc(100% - 255px)`)
    }
})

$(window).on('load', toggleSidebar).on('resize', toggleSidebar)

$('body').on('click', '#dropdown-user-btn', function () {
    $('#dropdown-user').toggleClass('hidden').css({
        top: '57px',
        left: '7px'
    })
})
$(document).on('click', function (e) {
    if (!e.target.closest('.sidebar') && !e.target.closest('.menu-btn') && $(window).width() < 640) {
        $('.sidebar').css({ right: '-255px' })
        $('.content').css('width', '100%')
    }
    if (!e.target.closest('#dropdown-user') && !e.target.closest('#dropdown-user-btn')) {
        $('#dropdown-user').addClass('hidden').removeClass('block')
    }
})

//before print
window.onbeforeprint = function () {

}
//after print
window.onafterprint = function () {
    
}
