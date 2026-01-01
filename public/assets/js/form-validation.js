/**
 * Form validation for Food Shop
 * Handles validation of forms throughout the site
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize validation for login form
  initLoginValidation();

  // Initialize validation for registration form
  initRegistrationValidation();

  // Initialize validation for checkout form
  initCheckoutValidation();

  // Initialize validation for profile form
  initProfileValidation();

  // Initialize password toggling
  initPasswordToggles();
});

/**
 * Initialize login form validation
 */
function initLoginValidation() {
  const loginForm = document.querySelector('form[action*="login.php"]');

  if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
      let isValid = true;

      // Get form fields
      const email = loginForm.querySelector('input[name="email"]');
      const password = loginForm.querySelector('input[name="password"]');

      // Validate email
      if (!email.value.trim()) {
        showFieldError(email, "Vui lòng nhập email");
        isValid = false;
      } else if (!isValidEmail(email.value.trim())) {
        showFieldError(email, "Email không hợp lệ");
        isValid = false;
      } else {
        clearFieldError(email);
      }

      // Validate password
      if (!password.value.trim()) {
        showFieldError(password, "Vui lòng nhập mật khẩu");
        isValid = false;
      } else {
        clearFieldError(password);
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
}

/**
 * Initialize registration form validation
 */
function initRegistrationValidation() {
  const registerForm = document.querySelector('form[action*="register.php"]');

  if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
      let isValid = true;

      // Get form fields
      const fullName = registerForm.querySelector('input[name="fullname"]');
      const email = registerForm.querySelector('input[name="email"]');
      const phone = registerForm.querySelector('input[name="phone"]');
      const password = registerForm.querySelector('input[name="password"]');
      const confirmPassword = registerForm.querySelector(
        'input[name="confirm_password"]'
      );

      // Validate full name
      if (!fullName.value.trim()) {
        showFieldError(fullName, "Vui lòng nhập họ tên");
        isValid = false;
      } else {
        clearFieldError(fullName);
      }

      // Validate email
      if (!email.value.trim()) {
        showFieldError(email, "Vui lòng nhập email");
        isValid = false;
      } else if (!isValidEmail(email.value.trim())) {
        showFieldError(email, "Email không hợp lệ");
        isValid = false;
      } else {
        clearFieldError(email);
      }

      // Validate phone
      if (phone && !phone.value.trim()) {
        showFieldError(phone, "Vui lòng nhập số điện thoại");
        isValid = false;
      } else if (phone && !isValidPhone(phone.value.trim())) {
        showFieldError(phone, "Số điện thoại không hợp lệ");
        isValid = false;
      } else if (phone) {
        clearFieldError(phone);
      }

      // Validate password
      if (!password.value.trim()) {
        showFieldError(password, "Vui lòng nhập mật khẩu");
        isValid = false;
      } else if (password.value.length < 6) {
        showFieldError(password, "Mật khẩu phải có ít nhất 6 ký tự");
        isValid = false;
      } else {
        clearFieldError(password);
      }

      // Validate confirm password
      if (!confirmPassword.value.trim()) {
        showFieldError(confirmPassword, "Vui lòng xác nhận mật khẩu");
        isValid = false;
      } else if (confirmPassword.value !== password.value) {
        showFieldError(confirmPassword, "Mật khẩu xác nhận không khớp");
        isValid = false;
      } else {
        clearFieldError(confirmPassword);
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
}

/**
 * Initialize checkout form validation
 */
function initCheckoutValidation() {
  const checkoutForm = document.querySelector('form[action*="checkout.php"]');

  if (checkoutForm) {
    checkoutForm.addEventListener("submit", function (event) {
      let isValid = true;

      // Get form fields
      const shippingAddress = checkoutForm.querySelector(
        'textarea[name="shipping_address"]'
      );
      const paymentMethod = checkoutForm.querySelector(
        'input[name="payment_method"]:checked'
      );
      const shippingMethod = checkoutForm.querySelector(
        'input[name="shipping_method"]:checked'
      );

      // Validate shipping address
      if (!shippingAddress.value.trim()) {
        showFieldError(shippingAddress, "Vui lòng nhập địa chỉ giao hàng");
        isValid = false;
      } else {
        clearFieldError(shippingAddress);
      }

      // Validate payment method
      if (!paymentMethod) {
        const paymentContainer = checkoutForm.querySelector(".payment-methods");
        showContainerError(
          paymentContainer,
          "Vui lòng chọn phương thức thanh toán"
        );
        isValid = false;
      }

      // Validate shipping method
      if (!shippingMethod) {
        const shippingContainer =
          checkoutForm.querySelector(".shipping-methods");
        showContainerError(
          shippingContainer,
          "Vui lòng chọn phương thức vận chuyển"
        );
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
        // Scroll to first error
        const firstError = checkoutForm.querySelector(".is-invalid");
        if (firstError) {
          firstError.scrollIntoView({ behavior: "smooth", block: "center" });
        }
      }
    });
  }
}

/**
 * Initialize profile form validation
 */
function initProfileValidation() {
  const profileForm = document.querySelector('form[action*="profile.php"]');

  if (profileForm) {
    profileForm.addEventListener("submit", function (event) {
      let isValid = true;

      // Get form fields
      const fullName = profileForm.querySelector('input[name="fullname"]');
      const email = profileForm.querySelector('input[name="email"]');
      const phone = profileForm.querySelector('input[name="phone"]');

      // Validate full name
      if (!fullName.value.trim()) {
        showFieldError(fullName, "Vui lòng nhập họ tên");
        isValid = false;
      } else {
        clearFieldError(fullName);
      }

      // Validate email
      if (!email.value.trim()) {
        showFieldError(email, "Vui lòng nhập email");
        isValid = false;
      } else if (!isValidEmail(email.value.trim())) {
        showFieldError(email, "Email không hợp lệ");
        isValid = false;
      } else {
        clearFieldError(email);
      }

      // Validate phone
      if (phone && !phone.value.trim()) {
        showFieldError(phone, "Vui lòng nhập số điện thoại");
        isValid = false;
      } else if (phone && !isValidPhone(phone.value.trim())) {
        showFieldError(phone, "Số điện thoại không hợp lệ");
        isValid = false;
      } else if (phone) {
        clearFieldError(phone);
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }

  // Password change form
  const passwordChangeForm = document.querySelector(
    'form[action*="change_password.php"]'
  );

  if (passwordChangeForm) {
    passwordChangeForm.addEventListener("submit", function (event) {
      let isValid = true;

      // Get form fields
      const currentPassword = passwordChangeForm.querySelector(
        'input[name="current_password"]'
      );
      const newPassword = passwordChangeForm.querySelector(
        'input[name="new_password"]'
      );
      const confirmPassword = passwordChangeForm.querySelector(
        'input[name="confirm_password"]'
      );

      // Validate current password
      if (!currentPassword.value.trim()) {
        showFieldError(currentPassword, "Vui lòng nhập mật khẩu hiện tại");
        isValid = false;
      } else {
        clearFieldError(currentPassword);
      }

      // Validate new password
      if (!newPassword.value.trim()) {
        showFieldError(newPassword, "Vui lòng nhập mật khẩu mới");
        isValid = false;
      } else if (newPassword.value.length < 6) {
        showFieldError(newPassword, "Mật khẩu mới phải có ít nhất 6 ký tự");
        isValid = false;
      } else {
        clearFieldError(newPassword);
      }

      // Validate confirm password
      if (!confirmPassword.value.trim()) {
        showFieldError(confirmPassword, "Vui lòng xác nhận mật khẩu mới");
        isValid = false;
      } else if (confirmPassword.value !== newPassword.value) {
        showFieldError(confirmPassword, "Mật khẩu xác nhận không khớp");
        isValid = false;
      } else {
        clearFieldError(confirmPassword);
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  }
}

/**
 * Initialize password toggle visibility
 */
function initPasswordToggles() {
  const passwordToggles = document.querySelectorAll(".password-toggle");

  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const input = this.closest(".input-group").querySelector("input");
      const icon = this.querySelector("i");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    });
  });
}

/**
 * Validate email format
 * @param {string} email - Email to validate
 * @returns {boolean} True if valid
 */
function isValidEmail(email) {
  const re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

/**
 * Validate phone number format (Vietnamese)
 * @param {string} phone - Phone to validate
 * @returns {boolean} True if valid
 */
function isValidPhone(phone) {
  // Basic Vietnamese phone validation: 10-11 digits, starting with 0
  const re = /^0\d{9,10}$/;
  return re.test(String(phone));
}

/**
 * Show error for a form field
 * @param {HTMLElement} field - The form field
 * @param {string} message - Error message
 */
function showFieldError(field, message) {
  // Add error class
  field.classList.add("is-invalid");

  // Find or create error message element
  let errorElement = field.nextElementSibling;
  if (!errorElement || !errorElement.classList.contains("invalid-feedback")) {
    errorElement = document.createElement("div");
    errorElement.className = "invalid-feedback";
    field.parentNode.insertBefore(errorElement, field.nextSibling);
  }

  // Set error message
  errorElement.textContent = message;
  errorElement.style.display = "block";
}

/**
 * Clear error for a form field
 * @param {HTMLElement} field - The form field
 */
function clearFieldError(field) {
  // Remove error class
  field.classList.remove("is-invalid");

  // Hide error message if it exists
  const errorElement = field.nextElementSibling;
  if (errorElement && errorElement.classList.contains("invalid-feedback")) {
    errorElement.style.display = "none";
  }
}

/**
 * Show error for a container (like radio button groups)
 * @param {HTMLElement} container - The container
 * @param {string} message - Error message
 */
function showContainerError(container, message) {
  // Add error class
  container.classList.add("border", "border-danger");

  // Find or create error message element
  let errorElement = container.querySelector(".invalid-feedback");
  if (!errorElement) {
    errorElement = document.createElement("div");
    errorElement.className = "invalid-feedback";
    container.appendChild(errorElement);
  }

  // Set error message
  errorElement.textContent = message;
  errorElement.style.display = "block";
}
