$(function () {
    // Thay đổi province
    $(".province").change(function (event) {
        // Act on the event /
        var province_id = $(this).val();
        if (!province_id) {
            updateSelectBox(null, ".district");
            updateSelectBox(null, ".ward");
            return;
        }

        $.ajax({
            url: `${$("#reference").val()}/address/${province_id}/districts`,
        }).done(function (data) {
            updateSelectBox(data, ".district");
            updateSelectBox(null, " .ward");
        });

        if ($(".shipping-fee").length) {
            $.ajax({
                url: `${$("#reference").val()}/address/shippingfee/${province_id}`,
            })
            .done(function(data) {
                //update shipping fee and total on UI
                let shipping_fee = Number(data);
                let payment_total = Number($(".sub-total").attr("data")) + shipping_fee;
                $(".shipping-fee").val(shipping_fee);
                $(".payment-total").html(number_format(payment_total) + " ₫");
            });
        }
    });

    // Thay đổi district
    $(".district").change(function (event) {
        // Act on the event /;
        var district_id = $(this).val();
        if (!district_id) {
            updateSelectBox(null, ".ward");
            return;
        }

        $.ajax({
            url: `${$("#reference").val()}/address/${district_id}/wards`,
        }).done(function (data) {
            updateSelectBox(data, ".ward");
        });
    });

    // Ajax search barcode
    let timeout = null;
    $("#search-barcode").on("keyup", function(event) {
        clearTimeout(timeout);
        $(".search-result").empty();
        $(".search-result").hide();

        const pattern = $(this).val();
        if(pattern.trim().length === 0){
            return;
        } else if(pattern.trim().length === 13) {
            timeout = setTimeout(function(){
                addProduct(pattern);
                $("#search-barcode").val("");
            }, 10);
        } else {
            timeout = setTimeout(function(){
                $.ajax({
                    url: `${$("#reference").val()}/admin/product/search/${pattern}`
                }).done(data => {
                    $(".search-result").html(data);
                    $(".search-result").show();
                    $(".search-result li a.product-name").click(function(event){
                        const barcode = $(this).attr("data");
                        addProduct(barcode);
                        $(".search-result").empty();
                        $(".search-result").hide();
                        $("#search-barcode").val("");
                    })
                })
            }, 500);
        }
    });

    // Thay đổi địa chỉ khi chọn khách hàng
    $("select[name=customer_id]").change(function (event) {
        const customer_id = $(this).val();
        $.ajax({
            url: `${$("#reference").val()}/admin/customer/address/${customer_id}`,
            success: data => {
                if(data){
                    const { address, housenumber_street } = JSON.parse(data);
                    const { district, district_id, id } = address;
                    const { province, province_id, wards } = district;
                    const { districts, transport } = province;
                    const { price } = transport;

                    updateSelectBox(districts, ".district");
                    updateSelectBox(wards, ".ward");
                    $(".province").val(province_id);
                    $(".district").val(district_id);
                    $(".ward").val(id);
                    $("input[name=housenumber_street]").val(housenumber_street);
                    $(".shipping-fee").val(price);
                    updateSubtotal();
                } else {
                    $(".province").val("");
                    updateSelectBox(null, ".district");
                    updateSelectBox(null, ".ward");
                    $("input[name=housenumber_street]").val("");
                    $(".shipping-fee").val(0);
                    updateSubtotal();
                }
            }
        });
    });
    $("input[name=featured_image]").change(function(event) {
        const { files } = event.target;
        if (files.length == 0) {
            $(".image-review").hide();
        } else {
            const tmppath = URL.createObjectURL(files[0]);
            $(".image-review img").attr("src", tmppath);
            $(".image-review").show();
        }
    });
});

function checkAll(check_all) {
    $(check_all).change(function () {
        var checkboxes = $(this).closest("table").find(":checkbox");
        checkboxes.prop("checked", $(this).is(":checked"));
    });
}

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector) {
    var items;
    try {
        items = JSON.parse(data);
    } catch (error) {
        items = data;
    }
    
    $(selector).find("option").not(":first").remove();
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let option =
            '<option value="' + item.id + '"> ' + item.name + "</option>";
        $(selector).append(option);
    }
}

function updateQty(order_id, product_id, self) {
    var qty = $(self).val();
    var order_id = $(self).attr("data");
    $.ajax({
        url: `${$("#reference").val()}/admin/orderAjaxAddItem/${order_id}/${product_id}/${qty}`,
        type: "GET",
    }).done(function (data) {
        var selector = `.order-total-price-${order_id}-${product_id}`;
        $(selector).html(data + "₫");
    });
}

function addProduct(barcode) {
    $.ajax({
        url: `${$("#reference").val()}/admin/product/find/${barcode}`,
        success: data => {
            displayAddProduct(data);
        }
    })
}

function displayAddProduct(data) {
    if(!data) return;
    const item = JSON.parse(data);
    const { id, barcode, name, featured_image, price, sale_price } = item;

    if(hasUpdateQty(id)){
        updateSubtotal();
        return;
    }
    const row = 
    `<tr>
        <td>
            ${barcode}
            <input type="hidden" name="product_id" value="${id}">
            <input type="hidden" name="product_ids[]" value="${id}">
        </td>
        <td>
            ${name}
        </td>
        <td>
            <img src="../../images/${featured_image}">
        </td>
        <td class="unit-price">
            ${ number_format(sale_price) }đ
            ${ price != sale_price ? `<del>${ number_format(price) }đ</del>` : "" }
        </td>
        <td>
            <input name="qties[]" data-sale-price="${ sale_price }" class="order-item-qty" type="number" min="1" value="1">
        </td>
        <td>
            <span class="order-item-money" data="${ sale_price }">
                ${ number_format(sale_price) } đ
            </span>
        </td>
        <td>
            <i class="fas fa-times order-item-delete"></i>
        </td>
    </tr>`

    $("table.product-item tbody").append(row);
    updateSubtotal();

    $(".order-item-delete").click(function(event) {
        $(this).parents("tr").remove();
        updateSubtotal();
    });
    $("input.order-item-qty").change(function(event) {
        const tr = $(this).parents("tr");
        let currentQty = Number($(this).val());
        const unitPrice = Number($(tr).find("input.order-item-qty").attr("data-sale-price"));
        $(tr).find(".order-item-money").html(number_format(currentQty * unitPrice) + " đ");
        $(tr).find(".order-item-money").attr("data", currentQty * unitPrice);
        updateSubtotal();
    });
}

function hasUpdateQty(product_id) {
    const productInputs = $("table.product-item input[name=product_id]");
    if(productInputs.length === 0) return false;
    for(let i = 0; i < productInputs.length; i++) {
        if(product_id == $(productInputs[i]).val()){
            const tr = $(productInputs[i]).parents("tr");
            let currentQty = Number($(tr).find("input.order-item-qty").val());
            const unitPrice = Number($(tr).find("input.order-item-qty").attr("data-sale-price"));
            
            $(tr).find("input.order-item-qty").val(++currentQty);
            $(tr).find(".order-item-money").html(number_format(currentQty * unitPrice) + " đ");
            $(tr).find(".order-item-money").attr("data", currentQty * unitPrice);
            return true;
        }
    }
    return false;
}

function updateSubtotal() {
    let subTotal = 0;
    const productInputs = $("table.product-item .order-item-money");
    for(let i = 0; i < productInputs.length; i++) {
        subTotal += Number($(productInputs[i]).attr("data"));
    }
    $(".sub-total").html(number_format(subTotal) + " đ");
    $(".sub-total").attr("data", subTotal);

    const shippingFee = Number($("input[name=shipping_fee]").val());
    $(".payment-total").html(number_format(subTotal + shippingFee) + " đ");
}