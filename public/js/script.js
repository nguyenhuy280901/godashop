function openMenuMobile() {
    $(".menu-mb").width("250px");
    $(".btn-menu-mb").hide("slow");
}

function closeMenuMobile() {
    $(".menu-mb").width(0);
    $(".btn-menu-mb").show("slow");
}

$(function(){ 
    
    $(".product-container").hover(function(){
        $(this).children(".button-product-action").toggle(400);
    });

    
    // Lọc sản phẩm theo danh mục
    $('main aside .category .category-filter').click(function(event){
        window.location.href = `${$("#reference").val()}/product?${getUpdatedParam('category_id', $(this).attr('data'))}`;
    });

    // Lọc sản phẩm theo giá
    $('main aside input[name=filter-price]').change(function(event){
        window.location.href = `${$("#reference").val()}/product?${getUpdatedParam('price_range', $(this).val())}`;
    });

    // Sắp xếp danh sách sản phẩm
    $('main #sort-select').change(function(event){
        if($(this).val() !== ""){
            window.location.href = `${$("#reference").val()}/product?${getUpdatedParam('sortby', $(this).val())}`;
        }
    });

    // Gửi mail liên hệ
    $('main form.form-contact').submit(function(event){
        event.preventDefault();
        $("#result").html(
            `<img style="width: 70px" src="../images/loading.gif" alt="loading...">`
        );
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        var form_data = $(this).serialize(); //Encode form elements for submission
        $.ajax({
            url: url,
            method: method,
            data: form_data
        }).done(data => {
            $("main form.form-contact input").val("");
            $("main form.form-contact textarea").val("");
            var message;
            if(data == "success")
                message = "<p class='text-danger'>Thông tin của quý khách đã được gửi! Chúng tôi sẽ liên hệ với quý khách sớm nhất có thể. Xin chân thành cảm ơn quý khách đã đóng góp ý kiến.</p>";
            else
                message = "<p class='text-danger'>Không thể gửi mail!! Vui lòng thử lại sau vài phút.</p>";
            $("#result").html(message);
        })
    });

    // Tìm kiếm bằng ajax
    var timeout = null;
    $('.header-form .search').keyup(function(event){
        clearTimeout(timeout);
        $(".search-result").html("");
        $(".search-result").hide();
        var pattern;
        pattern = $(this).val();
        if(pattern === ""){
            return;
        }
        timeout = setTimeout(function(){
            $.ajax({
                url: `${$("#reference").val()}/product/search/${pattern}`,
                method: 'GET'
            }).done(data => {
                $(".search-result").html(data);
                $(".search-result").show();
            });
        }, 500);
    });

    // Thay đổi province
    $("main .province").change(function(event) {
        var province_id = $(this).val();
        if (!province_id) {
            updateSelectBox(null, "main .district");
            updateSelectBox(null, "main .ward");
            return;
        }

        $.ajax({
            url: `${$("#reference").val()}/address/${province_id}/districts`,
            type: 'GET'
        })
        .done(function(data) {
            updateSelectBox(data, "main .district");
            updateSelectBox(null, "main .ward");
        });
        // thay đổi shippingfee theo province
        if ($("main .shipping-fee").length) {
            $.ajax({
                url: `${$("#reference").val()}/address/shippingfee/${province_id}`,
                type: 'GET'
            })
            .done(function(data) {
                let shipping_fee = Number(data);
                let payment_total = Number($("main .temp-total").attr("data")) + shipping_fee;
                $("main .shipping-fee").html(number_format(shipping_fee) + "₫");
                $("main input[name=shippingfee]").val(shipping_fee);
                $("main .payment-total").html(number_format(payment_total) + "₫");
            });
        }
    });

    // Thay đổi district
    $("main .district").change(function(event) {
        var district_id = $(this).val();
        if (!district_id) {
            updateSelectBox(null, "main .ward");
            return;
        }

        $.ajax({
            url: `${$("#reference").val()}/address/${district_id}/wards`,
            type: 'GET'
        })
        .done(function(data) {
            updateSelectBox(data, "main .ward");
        });
    });

    // Cập nhật thông tin khách hàng
    $("main .info-account").submit(function(event){
        var action = $("main .info-account input[name=action]").val();
        if(action === "update-info"){
            return true;
        }
        var newpwd = $("main .info-account input[name=password]").val();
        var confirmpwd = $("main .info-account input[name=re_password]").val();
        if(newpwd === confirmpwd){
            return true;
        }
        return false;
    });

    // Submit form đánh giá sản phẩm
    $("main .form-comment").submit(function(event){
        event.preventDefault();
        $(".form-comment .loading").html(
            `<img style="width: 50px; margin-top: -15px" src="../images/loading_post_comment.gif" alt="loading...">`
        );
        var product_id = $(".form-comment input[name=product_id]").val();
        var rating = $(".form-comment input[name=rating]").val();
        var description = $(".form-comment textarea[name=description]").val();
        $(".form-comment textarea[name=description]").val("");
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        $.ajax({
            url: url,
            method: method,
            data: { 
                product_id: product_id,
                rating: rating,
                description: description
            }
        }).done(data => {
            $(".form-comment .loading").html("");
            $("main .comment-list").prepend(data);
            updateAnsweredRating();
        });
    });

    // Thêm sản phẩm vào giỏ hàng
    $("main .buy").click(function(event){
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: `${$("#reference").val()}/cart/add/${product_id}/${1}`,
            type: 'GET'
        })
        .done(function(data) {
            displayCart(data);
        });
    });

    // Thêm sản phẩm vào giỏ hàng trong trang chi tiết sản phẩm
    $("main .buy-in-detail").click(function(event) {
        var qty = $(this).prev("input").val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            url: `${$("#reference").val()}/cart/add/${product_id}/${qty}`,
            type: 'GET'
        })
        .done(function(data) {
            displayCart(data);
        });
    });

    //display cart
    $.ajax({
        url: `${$("#reference").val()}/cart`,
        type: 'GET'
    })
    .done(function(data) {
        displayCart(data);
    });

    // Display or hidden button back to top
    $(window).scroll(function() { 
		 if ($(this).scrollTop()) { 
			 $(".back-to-top").fadeIn();
		 } 
		 else { 
			 $(".back-to-top").fadeOut(); 
		 } 
	 }); 

    // Khi click vào button back to top, sẽ cuộn lên đầu trang web trong vòng 0.8s
	 $(".back-to-top").click(function() { 
		$("html").animate({scrollTop: 0}, 800); 
	 });

	 // Hiển thị form đăng ký
	 $('.btn-register').click(function () {
	 	$('#modal-login').modal('hide');
        $('#modal-register').modal('show');
    });

	 // Hiển thị form forgot password
	$('.btn-forgot-password').click(function () {
		$('#modal-login').modal('hide');
    	$('#modal-forgot-password').modal('show');
    });

	 // Hiển thị form đăng nhập
	$('.btn-login').click(function () {
    	$('#modal-login').modal('show');
    });

	// Fix add padding-right 17px to body after close modal
	// Don't rememeber also attach with fix css
	$('.modal').on('hide.bs.modal', function (e) {
        e.stopPropagation();
        $("body").css("padding-right", 0);
        
    });

    // Hiển thị cart dialog
    $('.btn-cart-detail').click(function () {
    	$('#modal-cart-detail').modal('show');
    });

    // Hiển thị aside menu mobile
    $('.btn-aside-mobile').click(function () {
        $("main aside .inner-aside").toggle();
    });

    // Hiển thị carousel for product thumnail
    $('main .product-detail .product-detail-carousel-slider .owl-carousel').owlCarousel({
        margin: 10,
        nav: true
        
    });
    // Bị lỗi hover ở bộ lọc (mobile) & tạo thanh cuộn ngang
    // Khởi tạo zoom khi di chuyển chuột lên hình ở trang chi tiết
    // $('main .product-detail .main-image-thumbnail').ezPlus({
    //     zoomType: 'inner',
    //     cursor: 'crosshair',
    //     responsive: true
    // });
    
    // Cập nhật hình chính khi click vào thumbnail hình ở slider
    $('main .product-detail .product-detail-carousel-slider img').click(function(event) {
        /* Act on the event */
        $('main .product-detail .main-image-thumbnail').attr("src", $(this).attr("src"));
        var image_path = $('main .product-detail .main-image-thumbnail').attr("src");
        $(".zoomWindow").css("background-image", "url('" + image_path + "')");
        
    });

    $('main .product-detail .product-description .rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false
    });

    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });

    $('main .ship-checkout[name=payment_method]').click(function(event) {
        /* Act on the event */
    });

    $('input[name=checkout]').click(function(event) {
        /* Act on the event */
        window.location.href=`${$("#reference").val()}/order/checkout`;
    });

    $('input[name=back-shopping]').click(function(event) {
        /* Act on the event */
        window.location.href=`${$("#reference").val()}/product`;
    });
    
    // Hiển thị carousel for relative products
    $('main .product-detail .product-related .owl-carousel').owlCarousel({
            loop:false,
            margin: 10,
            nav: true,
            dots:false,
            responsive:{
            0:{
                items:2
            },
            600:{
                items:4
            },
            1000:{
                items:5
            }
        }
    });
});

// Login in google
function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://study.com/register/google/backend/process.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
    };
    xhr.send('idtoken=' + id_token);
}

// Cập nhật giá trị của 1 param cụ thể
function getUpdatedParam($param, $value) {
    var params = {};
    window.location.search
    .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str,key,value){
        params[key] = value;
        // params["page"] = 3;
    });
      
    //param: {"c":"proudct", "page": 4} => c=product&page=4
    params[$param] = $value;

    var x = [];
    for (p in params) {
        //x[0] = 'c=product'
        //x[1] = 'page=4'
        x.push(p + "=" + params[p]);
    }
    // ["c=product", "page=4"]
    return str_param = x.join("&"); //c=product&page=4
}


// Cập nhật các option cho thẻ select
function updateSelectBox(data, selector) {
    var items = JSON.parse(data);
    $(selector).find('option').not(':first').remove();
    if (!data) return;
    for (let i = 0; i < items.length; i++) {
        let item = items[i];
        let option = '<option value="' + item.id + '"> ' + item.name + '</option>';
        $(selector).append(option);
    }
}

// Hiển thị những rating của những đánh giá
function updateAnsweredRating(){
    $('main .product-detail .product-description .answered-rating-input').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'md',
        stars: "5",
        showClear: false,
        showCaption: false,
        displayOnly: false,
        hoverEnabled: true
    });
}

// Hiển thị cart
function displayCart(data) {
    var cart = JSON.parse(data);
    var total_product_number = 0;
    var total_price = 0;
    var rows = "";
    $("input[name=checkout]").prop("disabled", cart.length == 0);
    for(row_id in cart){
        const { id, name, qty, price, subtotal, options } = cart[row_id];
        total_price += subtotal;
        total_product_number += Number(qty);

        let row =   '<hr>' +
                    '<div class="clearfix text-left">' +
                        '<div class="row">' +
                            '<div class="col-sm-6 col-md-1">' +
                                '<div><img class="img-responsive" src="' + $("#reference").val() + '/images/'+ options.featured_image +'" alt="'+ name +'"></div>' +
                            '</div>' +
                            '<div class="col-sm-6 col-md-3"><a class="product-name" href="/product/' + id + '">'+ name +'</a></div>' +
                            '<div class="col-sm-6 col-md-2"><span class="product-item-discount">'+ number_format(price) +'₫</span></div>' +
                            '<div class="col-sm-6 col-md-3"><input type="hidden" value="'+ id +'"><input type="number" onchange="updateProductInCart(this,\''+ row_id +'\')" min="1" value="'+ qty +'"></div>' +
                            '<div class="col-sm-6 col-md-2"><span>'+ number_format(subtotal) +'₫</span></div>' +
                            '<div class="col-sm-6 col-md-1"><a class="remove-product" href="javascript:void(0)" onclick="deleteProductInCart(\''+ row_id +'\')"><span class="glyphicon glyphicon-trash"></span></a></div>' +
                        '</div>' +
                    '</div>';
        rows += row;
    }
    $("#modal-cart-detail .cart-product").html(rows);
    $(".btn-cart-detail .number-total-product").html(total_product_number);
    $("#modal-cart-detail .price-total").html(number_format(total_price)+"₫");
}

// Thay đổi số lượng sản phẩm trong giỏ hàng
function updateProductInCart(self, row_id) {
    var qty = $(self).val();
    $.ajax({
        url: `${$("#reference").val()}/cart/update/${row_id}/${qty}`,
        type: 'GET'
    })
    .done(function(data) {
        displayCart(data);
    });
}

// Delete sản phẩm trong giỏ hàng
function deleteProductInCart(row_id) {
    $.ajax({
        url: `${$("#reference").val()}/cart/delete/${row_id}`,
        type: 'GET'
    })
    .done(function(data) {
        displayCart(data);
    });
}