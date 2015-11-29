function enableReviewForm(id) {
    var display = document.getElementById(id).style.display;
    if (display === 'none') {
        document.getElementById(id).style.display = 'block';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}

function sentCart(id) {
    $.ajax({
        method: "GET",
        url: "/cart/add/" + id,
        data: {}
    }).done(
        function () {
            window.location.replace('/cart')
        }
    );
}

function sentAjax(id, name) {
    $.ajax({
        method: "GET",
        url: "/cart/add/" + id,
        data: {}
    }).done(
        function (msg) {
            document.getElementById("#").style.display = 'block';
            document.getElementById("#").innerHTML = '"' + name + '" added to cart!';
        }
    );
}