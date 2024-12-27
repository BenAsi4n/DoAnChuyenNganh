document.addEventListener('DOMContentLoaded', () => {
    const mainImg = document.querySelector('.main-img');
    const thumbnails = document.querySelectorAll('.thumbnails img');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            const currentMainImgSrc = mainImg.src;
            mainImg.src = thumbnail.src;
            thumbnail.src = currentMainImgSrc;
        });
    });
    document.querySelector('.add-to-cart').addEventListener('click', () => {
        const selectedSize = document.querySelector('.select-button.active')?.getAttribute('name');
        const selectedColor = document.querySelector('.color-button.active')?.getAttribute('name');
        const tensp = document.querySelector('.product_tensp').innerText;
        const gia = document.querySelector('.price').innerText.replace(' đ', '').replace('.', '');
        const hinh = document.querySelector('.main-img').src;
        if (!selectedSize || !selectedColor) {
            alert("Vui lòng chọn kích thước và màu sắc!");
            return;
        }
        console.log("Size:", selectedSize);
        console.log("Color:", selectedColor);
        
        const data = {
            sanpham_id: productID,
            soluong: 1,
            detail: `${selectedColor}, ${selectedSize}`,
            tensp: tensp,
            gia: gia,
            hinh: hinh,
        };
        console.log(data);
        // Gửi dữ liệu qua AJAX
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Thêm vào giỏ hàng thành công!");
                location.href = 'cart.php';
            } else {
                alert("Có lỗi xảy ra: " + result.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });
});

function selectButton(event) {
    // Xóa class 'active' ở tất cả các nút
    const buttons = document.querySelectorAll('.select-button');
    buttons.forEach(button => button.classList.remove('active'));

    // Thêm class 'active' cho nút được nhấn
    event.target.classList.add('active');
}

function selectColor(event) {
    // Xóa class 'active' ở tất cả các nút màu
    const colors = document.querySelectorAll('.color-button');
    colors.forEach(color => color.classList.remove('active'));

    // Thêm class 'active' cho nút màu được nhấn
    event.target.classList.add('active');
}