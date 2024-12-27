
document.addEventListener("DOMContentLoaded", function () {
    const updateQuantity = (id, action) => {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                location.reload(); // Tải lại trang để cập nhật giỏ hàng
            }
        };
        xhr.send(`id=${id}&action=${action}`);
    };

    document.querySelectorAll(".btn-increase").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            updateQuantity(id, "increase");
        });
    });

    document.querySelectorAll(".btn-decrease").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            updateQuantity(id, "decrease");
        });
    });

    document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            updateQuantity(id, "delete");
        });
    });
});
