// Kiểm tra nếu URL có chứa tham số
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("error") && urlParams.get("error") === "invalid") {
  alert("Sai thông tin đăng nhập!");
} else if (urlParams.has("status") && urlParams.get("status") === "error") {
  alert("Đăng ký không thành công!");
} else if (urlParams.has("status") && urlParams.get("status") === "success") {
  alert("Đăng ký thành công!");
} else if (urlParams.has("status") && urlParams.get("status") === "timeout") {
  alert("Phiên đăng nhập đã hết! Vui lòng đăng nhập lại.");
}
//new url cho login

// tb lỗi cho các action
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const message = urlParams.get("message");
  const mod = urlParams.get("mod");
  const error = urlParams.get("error");

  if (message || error) {
    const noti = document.getElementById("notification");
    const messages = {
      success: "Thêm thành công.",
      delsuccess: "Xóa thành công.",
      update: "Cập nhật thành công",
      error: "Lỗi: Không thể cập nhật cơ sở dữ liệu!",
      empty: "Vui lòng nhập dữ liệu!",
      invalid: "Lỗi!",
      not_admin: "Bạn không phải admin!",
      not: "Tài khoản không thể đăng nhập",
      invalid_password: "Sai mật khẩu",
      user_not_found: "Hãy kiểm tra tên đăng nhập và mật khẩu!",
      errorFile: "Lỗi file hình",
      errorUp: "Không thể upload file hình",
      duplicate:"Đã tồn tại"
    };

    noti.textContent = messages[message] || "Đã xảy ra lỗi!";

    noti.classList.remove("hidden");

    setTimeout(() => {
      noti.classList.add("hidden");

      const newUrl = window.location.pathname + (mod ? `?mod=${mod}` : ""); // Giữ lại "mod" nếu có
      window.history.replaceState({}, "", newUrl); // Thay đổi URL mà không làm mới trang
    }, 2000);
  }
});

//hiện pass
function togglePassword() {
  const passwordField = document.getElementById("password");
  const showPasswordCheckbox = document.getElementById("show-password");
  if (showPasswordCheckbox.checked) {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
}

//xác nhận xóa
document.querySelectorAll(".delete-btn").forEach(function (btn) {
  btn.addEventListener("click", function (event) {
    if (!confirm("Bạn có chắc chắn muốn xóa?")) {
      event.preventDefault();
    }
  });
});
//xác nhận update admin
document.querySelectorAll(".update-btn").forEach(function (btn) {
  btn.addEventListener("click", function (event) {
    if (!confirm("Cập nhật này sẽ ảnh hưởng đến hệ thống?")) {
      event.preventDefault();
    }
  });
});
