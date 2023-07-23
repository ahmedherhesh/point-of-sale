$(".delete-btn").on("click", function (e) {
    let result = confirm(`هل انت متأكد من حذف ${$(this).data("type")}`);
    if (!result) e.preventDefault();
});
let deliveryBtn = document.querySelectorAll(".delivery-btn");
if (deliveryBtn)
    deliveryBtn.forEach((el) => {
        el.onclick = function () {
            item_id.value = this.getAttribute("data-item-id");
        };
    });
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
