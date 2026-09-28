var quantity = document.getElementById("quantity");
var price = document.getElementById("unit_price");
var total = document.getElementById("total");
function calculateTotal() {
    var q = parseFloat(quantity.value);
    var p = parseFloat(price.value);
    if (isNaN(q)) q = 0;
    if (isNaN(p)) p = 0;
    total.value = (q * p).toFixed(2);
}
if (quantity && price && total) {
    quantity.addEventListener("input", calculateTotal);
    price.addEventListener("input", calculateTotal);
}
