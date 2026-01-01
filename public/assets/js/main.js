/**
 * Main JavaScript file for Food Shop
 * Contains general functionality used across the site
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize sliders if they exist
  initSliders();

  // Initialize tooltips
  initTooltips();

  // Initialize quantity controls
  initQuantityControls();

  // Handle notification alerts
  handleNotifications();
});

/**
 * Initialize any slick sliders on the page
 */
function initSliders() {
  // Hero slider
  if ($(".slide-gioi-thieu").length) {
    $(".slide-gioi-thieu").slick({
      dots: true,
      arrows: false,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: "linear",
      autoplay: true,
      autoplaySpeed: 5000,
    });
  }

  // Testimonial slider
  if ($(".testimonial-slider").length) {
    $(".testimonial-slider").slick({
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 5000,
    });
  }
}

/**
 * Initialize Bootstrap tooltips
 */
function initTooltips() {
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
}

/**
 * Initialize quantity controls
 */
function initQuantityControls() {
  const minusBtns = document.querySelectorAll(".btn-minus");
  const plusBtns = document.querySelectorAll(".btn-plus");

  minusBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const input = this.closest(".qty-control").querySelector("input");
      let value = parseInt(input.value);
      if (value > 1) {
        input.value = value - 1;
        triggerChangeEvent(input);
      }
    });
  });

  plusBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const input = this.closest(".qty-control").querySelector("input");
      let value = parseInt(input.value);
      let max = parseInt(input.getAttribute("max") || 99);
      if (value < max) {
        input.value = value + 1;
        triggerChangeEvent(input);
      }
    });
  });
}

/**
 * Trigger change event for an element
 * @param {HTMLElement} element - The element to trigger the event on
 */
function triggerChangeEvent(element) {
  const event = new Event("change", { bubbles: true });
  element.dispatchEvent(event);
}

/**
 * Handle notification alerts
 */
function handleNotifications() {
  // Auto-dismiss alerts after 5 seconds
  const alerts = document.querySelectorAll(".alert-dismissible");
  alerts.forEach((alert) => {
    setTimeout(() => {
      const closeButton = alert.querySelector(".btn-close");
      if (closeButton) {
        closeButton.click();
      }
    }, 5000);
  });
}

/**
 * Show a toast notification
 * @param {string} message - The message to display
 * @param {string} type - The type of toast (success, error, warning, info)
 * @param {string} title - The toast title
 */
function showToast(message, type = "info", title = "") {
  // Set default titles based on type
  if (!title) {
    switch (type) {
      case "success":
        title = "Thành công";
        break;
      case "error":
        title = "Lỗi";
        break;
      case "warning":
        title = "Cảnh báo";
        break;
      default:
        title = "Thông báo";
    }
  }

  // Create toast element
  const toastEl = document.createElement("div");
  toastEl.className = `toast toast-${type}`;
  toastEl.setAttribute("role", "alert");
  toastEl.setAttribute("aria-live", "assertive");
  toastEl.setAttribute("aria-atomic", "true");

  toastEl.innerHTML = `
        <div class="toast-header">
            <strong class="me-auto">${title}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ${message}
        </div>
    `;

  // Add to container (create if doesn't exist)
  let toastContainer = document.querySelector(".toast-container");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.className = "toast-container position-fixed top-0 end-0 p-3";
    document.body.appendChild(toastContainer);
  }

  toastContainer.appendChild(toastEl);

  // Initialize Bootstrap toast and show it
  const toast = new bootstrap.Toast(toastEl, {
    autohide: true,
    delay: 5000,
  });
  toast.show();

  // Remove from DOM after hidden
  toastEl.addEventListener("hidden.bs.toast", function () {
    toastEl.remove();
  });
}

/**
 * Format currency (VND)
 * @param {number} amount - Amount to format
 * @returns {string} Formatted currency string
 */
function formatCurrency(amount) {
  return (
    new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" })
      .format(amount)
      .replace("₫", "")
      .trim() + " đ"
  );
}

/**
 * Truncate text to a specific length and add ellipsis
 * @param {string} text - The text to truncate
 * @param {number} length - Maximum length
 * @returns {string} Truncated text with ellipsis if needed
 */
function truncateText(text, length) {
  if (text.length <= length) return text;
  return text.substring(0, length) + "...";
}
