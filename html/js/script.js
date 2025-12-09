// Giữ tab active khi reload
document.addEventListener("DOMContentLoaded", function () {
  const hash = window.location.hash;
  if (hash) {
    const tabTrigger = document.querySelector(`a[href="${hash}"]`);
    if (tabTrigger) {
      const tab = new bootstrap.Tab(tabTrigger);
      tab.show();
    }
  }

  // Xử lý click tab
  const tabLinks = document.querySelectorAll("#sidebarTabs .nav-link");
  tabLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // ngăn trình duyệt chỉ đổi URL
      const tab = new bootstrap.Tab(link);
      tab.show(); // hiển thị ngay giao diện tab

      // Cập nhật URL
      history.replaceState(null, null, link.getAttribute("href"));
    });
  });
  // Xử lý form lọc
  const filterForm = document.getElementById("filterForm");
  if (filterForm) {
    filterForm.addEventListener("submit", function (e) {
      e.preventDefault(); // chặn reload và query string
      // lấy dữ liệu lọc
      const age = document.getElementById("ageRange").value;
      const gender = document.getElementById("gender").value;
      const orientation = document.getElementById("orientation").value;
      const interest = document.getElementById("interest").value;
      console.log("Filter:", { age, gender, orientation, interest });
      // TODO: lọc danh sách user theo dữ liệu trên
    });
  }

  const form = document.getElementById("userRegistrationForm");
  form.addEventListener("submit", function (e) {
    let errors = [];

    // Lấy giá trị các trường
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const birthMonth = form.birthMonth.value;
    const birthDay = form.birthDay.value;
    const birthYear = form.birthYear.value;
    const gender = form.gender.value;
    const interestedIn = form.interestedIn.value;
    const relationshipIntent = form.relationshipIntent.value;
    const orientation = form.orientation.value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const photos = form.elements["profilePhotos"].files;

    // Kiểm tra tên
    if (name.length < 2) {
      errors.push("Tên phải có ít nhất 2 ký tự.");
    }

    // Kiểm tra email
    const emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
    if (!emailPattern.test(email)) {
      errors.push("Email không hợp lệ.");
    }

    // Kiểm tra ngày sinh
    if (!birthMonth || !birthDay || !birthYear) {
      errors.push("Vui lòng chọn đầy đủ ngày sinh.");
    }

    // Kiểm tra giới tính
    if (!gender) {
      errors.push("Vui lòng chọn giới tính.");
    }

    // Kiểm tra quan tâm đến
    if (!interestedIn) {
      errors.push("Vui lòng chọn đối tượng quan tâm.");
    }

    // Kiểm tra mục đích tìm kiếm
    if (!relationshipIntent) {
      errors.push("Vui lòng chọn mục đích tìm kiếm.");
    }

    // Kiểm tra xu hướng tính dục
    if (!orientation) {
      errors.push("Vui lòng chọn xu hướng tính dục.");
    }

    // Kiểm tra mật khẩu
    if (password.length < 6) {
      errors.push("Mật khẩu phải có ít nhất 6 ký tự.");
    }
    if (password !== confirmPassword) {
      errors.push("Mật khẩu xác nhận không khớp.");
    }

    // Kiểm tra ảnh đại diện
    if (photos.length < 1) {
      errors.push("Vui lòng tải lên ít nhất 1 ảnh đại diện.");
    }

    // Nếu có lỗi thì ngăn submit và hiển thị
    if (errors.length > 0) {
      e.preventDefault();
      const errorBox = document.getElementById("formErrors");
      errorBox.innerHTML = "";
      errors.forEach((msg) => {
        const p = document.createElement("p");
        p.textContent = msg;
        errorBox.appendChild(p);
      });
    }
  });
});
