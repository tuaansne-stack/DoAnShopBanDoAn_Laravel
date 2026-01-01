/**
 * Food Shop - Animation and Effects Script
 * Enhances user experience with smooth animations and visual effects
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize animation effects
  initAnimations();

  // Initialize hover effects
  initHoverEffects();

  // Initialize scroll animations
  initScrollAnimations();

  // Initialize notification system
  initNotifications();

  // Initialize lazy loading for images
  initLazyLoading();
});

/**
 * Initialize basic animations for page elements
 */
function initAnimations() {
  // Animate hero section elements on load
  const heroElements = document.querySelectorAll(
    ".hero-section h1, .hero-section p, .hero-section .btn"
  );
  heroElements.forEach((element, index) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(20px)";

    setTimeout(() => {
      element.style.transition = "all 0.5s ease";
      element.style.opacity = "1";
      element.style.transform = "translateY(0)";
    }, 300 + index * 200);
  });

  // Animate card elements with staggered delay
  const animatedCards = document.querySelectorAll(
    ".card-food, .category-card, .news-card"
  );
  animatedCards.forEach((card, index) => {
    card.style.opacity = "0";
    card.style.transform = "translateY(20px)";

    setTimeout(() => {
      card.style.transition =
        "all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
      card.style.opacity = "1";
      card.style.transform = "translateY(0)";
    }, 500 + (index % 4) * 150);
  });
}

/**
 * Initialize hover effects for interactive elements
 */
function initHoverEffects() {
  // Add hover effect for navigation items
  const navItems = document.querySelectorAll(".nav-link");
  navItems.forEach((item) => {
    item.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-3px)";
      this.style.transition = "all 0.3s ease";
    });

    item.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)";
    });
  });

  // Add click ripple effect for buttons
  const buttons = document.querySelectorAll(".btn-gradient, .btn-primary");
  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const x = e.clientX - e.target.getBoundingClientRect().left;
      const y = e.clientY - e.target.getBoundingClientRect().top;

      const ripple = document.createElement("span");
      ripple.classList.add("ripple-effect");
      ripple.style.left = `${x}px`;
      ripple.style.top = `${y}px`;

      this.appendChild(ripple);

      setTimeout(() => {
        ripple.remove();
      }, 600);
    });
  });
}

/**
 * Initialize scroll-based animations
 */
function initScrollAnimations() {
  // Animate elements when they come into view
  const animateOnScroll = () => {
    const elements = document.querySelectorAll(".animate-on-scroll");

    elements.forEach((element) => {
      const elementTop = element.getBoundingClientRect().top;
      const elementVisible = 150;

      if (elementTop < window.innerHeight - elementVisible) {
        element.classList.add("animated");
      }
    });
  };

  // Initial check and add scroll event listener
  animateOnScroll();
  window.addEventListener("scroll", animateOnScroll);

  // Parallax effect for background images
  const parallaxElements = document.querySelectorAll(".parallax-bg");
  window.addEventListener("scroll", () => {
    parallaxElements.forEach((element) => {
      const scrollPosition = window.pageYOffset;
      const speed = element.dataset.speed || 0.5;
      element.style.transform = `translateY(${scrollPosition * speed}px)`;
    });
  });
}

/**
 * Initialize notification system
 */
function initNotifications() {
  // Create a toast notification
  window.showToast = function (message, type = "success", duration = 3000) {
    // Remove any existing toasts
    const existingToasts = document.querySelectorAll(".toast-notification");
    existingToasts.forEach((toast) => toast.remove());

    // Create new toast element
    const toast = document.createElement("div");
    toast.className = `toast-notification toast-${type}`;
    toast.style.opacity = "0";
    toast.style.transform = "translateY(-20px)";

    // Add icon based on type
    let icon = "check-circle";
    if (type === "error") icon = "times-circle";
    if (type === "warning") icon = "exclamation-triangle";
    if (type === "info") icon = "info-circle";

    toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close"><i class="fas fa-times"></i></button>
        `;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
      toast.style.transition =
        "all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55)";
      toast.style.opacity = "1";
      toast.style.transform = "translateY(0)";
    }, 10);

    // Add close button functionality
    const closeBtn = toast.querySelector(".toast-close");
    closeBtn.addEventListener("click", () => {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(-20px)";
      setTimeout(() => toast.remove(), 400);
    });

    // Auto remove after duration
    setTimeout(() => {
      if (document.body.contains(toast)) {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-20px)";
        setTimeout(() => toast.remove(), 400);
      }
    }, duration);
  };

  // Initialize cart animation effects
  initCartEffects();
}

/**
 * Initialize cart-related effects
 */
function initCartEffects() {
  // Add to cart animation
  const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Add visual feedback
      this.classList.add("adding");

      setTimeout(() => {
        this.classList.remove("adding");
      }, 1500);

      // Find the cart icon in header and animate it
      const cartIcon = document.querySelector(".cart-icon");
      if (cartIcon) {
        cartIcon.classList.add("cart-pulse");
        setTimeout(() => {
          cartIcon.classList.remove("cart-pulse");
        }, 1000);
      }
    });
  });
}

/**
 * Initialize lazy loading for images
 */
function initLazyLoading() {
  // Handle images with loading="lazy"
  const lazyImages = document.querySelectorAll('img[loading="lazy"]');
  
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.classList.add('loaded');
          observer.unobserve(img);
        }
      });
    });

    lazyImages.forEach(img => {
      imageObserver.observe(img);
    });
  } else {
    // Fallback for browsers without IntersectionObserver
    lazyImages.forEach(img => {
      img.classList.add('loaded');
    });
  }
}

// Add CSS for the new animation effects
const styleSheet = document.createElement("style");
styleSheet.type = "text/css";
styleSheet.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.7);
        width: 100px;
        height: 100px;
        margin-top: -50px;
        margin-left: -50px;
        animation: ripple 0.6s linear;
        transform: scale(0);
        opacity: 1;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }
    
    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 10px;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        min-width: 300px;
        max-width: 90%;
        z-index: 9999;
    }
    
    .toast-content {
        display: flex;
        align-items: center;
    }
    
    .toast-content i {
        margin-right: 15px;
        font-size: 1.2rem;
    }
    
    .toast-success i {
        color: #28a745;
    }
    
    .toast-error i {
        color: #ff5c8d;
    }
    
    .toast-warning i {
        color: #ffc107;
    }
    
    .toast-info i {
        color: #17a2b8;
    }
    
    .toast-close {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .toast-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    
    .add-to-cart-btn.adding {
        position: relative;
        overflow: hidden;
    }
    
    .add-to-cart-btn.adding:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        animation: addingAnimation 1.5s ease;
    }
    
    @keyframes addingAnimation {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: 100%; }
    }
    
    .cart-pulse {
        animation: cartPulse 1s ease;
    }
    
    @keyframes cartPulse {
        0% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(1); }
        75% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(styleSheet);
