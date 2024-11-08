import { useForm } from "@inertiajs/vue3";
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
let saleForm = useForm({
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
    result = result - (parseFloat(saleForm.discount) || 0);
    $('#finalPrice').text(result);
    $('#leftCost').text((parseFloat($('.left-cost').val()) - result) || 0)
};
export { totalPrice, getParams, saleForm, cartEls };