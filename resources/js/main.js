import { reactive } from "vue";

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
export { totalPrice, saleForm ,cartEls};