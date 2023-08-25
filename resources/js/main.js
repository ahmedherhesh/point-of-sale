import { reactive } from "vue";
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
let saleForm = reactive({
    discount: '',
    customer_name: '',
    customer_phone: '',
    items: []
});
let cartEls = reactive([]);
const totalPrice = () => {
    let result = 0;
    $('.total-price').each(function () {
        result += parseFloat($(this).text())
    })
    $('#finalPrice').text(result - (parseFloat(saleForm.discount) || 0));
};
export { totalPrice, getParams, saleForm, cartEls };