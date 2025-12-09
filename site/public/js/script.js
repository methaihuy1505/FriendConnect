document.addEventListener("DOMContentLoaded", function () {
  // Giữ tab active khi reload
  const hash = window.location.hash;
  if (hash) {
    const tabTrigger = document.querySelector(`a[href="${hash}"]`);
    if (tabTrigger) {
      const tab = new bootstrap.Tab(tabTrigger);
      tab.show();
    }
  }

  // Xử lý click tab
  const tabLinks = document.querySelectorAll(
    '#sidebarTabs .nav-link[data-toggle="pill"]'
  );
  tabLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const tab = new bootstrap.Tab(link);
      const href = link.getAttribute("href"); // "#edit"
      const basePath = window.location.pathname; // "/index.php"
      const newUrl = `${basePath}?c=dashboard${href}`;
      history.replaceState(null, null, newUrl);
      tab.show();
    });
  });

  //Bộ lọc
  const filterForm = document.getElementById("filterForm");
  if (filterForm) {
    filterForm.addEventListener("submit", function () {
      setTimeout(() => {
        if (!window.location.hash) {
          window.location.hash = "explore";
        }
      }, 50);
    });
  }

  //validate
  const form = document.getElementById("userRegistrationForm");
  if (form) {
    form.addEventListener("submit", function (e) {
      let errors = [];
      console.log("Form submit JS chạy");
      // Lấy giá trị các trường
      const name = document.getElementById("Name").value.trim();
      const email = document.getElementById("Email").value.trim();
      const birthMonth = form.birthMonth.value;
      const birthDay = form.birthDay.value;
      const birthYear = form.birthYear.value;
      const gender = form.gender.value;
      const interestedIn = form.interested_in.value;
      const relationshipIntent = form.relationship_intent.value;
      const orientation = form.orientation.value;
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;
      const photos = form.elements["avatar_url"].files;

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
  }
  //Xử lý scroll list
  function initSlider(section) {
    const track = section.querySelector(".user-scroll");
    const left = section.querySelector(".left-btn");
    const right = section.querySelector(".right-btn");
    if (!track || !left || !right) return;

    const step = 260; // gần bằng card width + gap

    const updateButtons = () => {
      const maxScroll = track.scrollWidth - track.clientWidth;
      section.classList.toggle("can-scroll-left", track.scrollLeft > 0);
      section.classList.toggle(
        "can-scroll-right",
        track.scrollLeft < maxScroll
      );
    };

    left.addEventListener("click", () => {
      track.scrollBy({ left: -step, behavior: "smooth" });
    });
    right.addEventListener("click", () => {
      track.scrollBy({ left: step, behavior: "smooth" });
    });

    track.addEventListener("scroll", updateButtons);
    window.addEventListener("resize", updateButtons);
    updateButtons();
  }

  document
    .querySelectorAll(".explore-section .slider-wrap")
    .forEach(initSlider);

  //Xử lý khi thêm câu hỏi
  let nextId = 1;
  const list = document.getElementById("questionList");
  const tpl = document.getElementById("questionTemplate");
  const addBtn = document.getElementById("addQuestionBtn");
  if (addBtn) {
    addBtn.addEventListener("click", () => {
      const clone = tpl.content.cloneNode(true);
      const card = clone.querySelector(".question-card");
      card.id = "question-" + nextId;
      card.dataset.uid = nextId;

      // gán số thứ tự hiển thị
      clone.querySelector(".q-index").textContent = list.children.length + 1;

      // gán name cho input
      clone.querySelector(
        ".question-content"
      ).name = `questions[${nextId}][content]`;

      // gán name cho 4 option
      clone.querySelectorAll(".option-content").forEach((opt, idx) => {
        opt.name = `questions[${nextId}][options][${idx + 1}][content]`;
      });

      // gán name cho dropdown đáp án đúng
      clone.querySelector(
        ".answer-select"
      ).name = `questions[${nextId}][answer]`;

      list.appendChild(clone);
      nextId++;
    });
  }
  function renumber() {
    list
      .querySelectorAll(".q-index")
      .forEach((el, i) => (el.textContent = i + 1));
  }
  document.querySelectorAll("#questionList .remove-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.closest(".question-card").remove();
      renumber();
    });
  });

  //Challenge Form ẩn hiện
  const challengeCards = document.querySelectorAll(".card");
  const title = document.querySelector("h3");

  document.querySelectorAll(".select-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;

      // Ẩn danh sách thử thách
      challengeCards.forEach((c) => c.classList.add("d-none"));

      // Đổi tiêu đề
      title.textContent = "Danh sách câu hỏi";

      // Hiện form của challenge được chọn
      document.getElementById("challenge-" + id).classList.remove("d-none");
    });
  });

  document.querySelectorAll(".back-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      // Ẩn form hiện tại
      btn.closest(".challenge-form").classList.add("d-none");

      // Hiện lại danh sách thử thách
      challengeCards.forEach((c) => c.classList.remove("d-none"));

      // Đổi lại tiêu đề
      title.textContent = "Danh sách thử thách";
    });
  });
});
