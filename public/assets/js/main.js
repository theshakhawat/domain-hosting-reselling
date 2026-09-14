/**
 * NEXUSHOST - Modern Minimalist Hosting & Domain Reselling Platform
 * Production Vanilla JavaScript
 * Zero external frameworks/libraries. Strictly interacts with hard-coded HTML DOM.
 */

document.addEventListener('DOMContentLoaded', () => {
  initThemeToggle();
  initNavbarScroll();
  initMobileNav();
  initHostingTabs();
  initBillingToggle();
  initDomainSearch();
  initSpecModal();
  initFaqAccordion();
  initTestimonialSlider();
  initPromoCountdown();
  initCopyPromoCode();
  initBackToTop();
  initOrderTriggers();
});

/* ==========================================================================
   1. DARK / LIGHT THEME TOGGLE WITH LOCALSTORAGE PERSISTENCE
   ========================================================================== */
function initThemeToggle() {
  const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
  const themeIcons = document.querySelectorAll('.theme-toggle-icon');

  function updateThemeUI(isDark) {
    if (isDark) {
      document.documentElement.classList.add('dark');
      themeIcons.forEach(icon => {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
      });
    } else {
      document.documentElement.classList.remove('dark');
      themeIcons.forEach(icon => {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
      });
    }
  }

  // Initial check: if html already has 'dark' class from head script, sync icons
  const isCurrentlyDark = document.documentElement.classList.contains('dark');
  updateThemeUI(isCurrentlyDark);

  themeToggleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      const newTheme = isDark ? 'light' : 'dark';
      
      localStorage.setItem('hosting_theme', newTheme);
      updateThemeUI(newTheme === 'dark');
    });
  });
}

/* ==========================================================================
   2. NAVBAR SCROLL EFFECT
   ========================================================================== */
function initNavbarScroll() {
  const navbar = document.getElementById('main-navbar');
  if (!navbar) return;

  const handleScroll = () => {
    if (window.scrollY > 20) {
      navbar.classList.add('shadow-sm', 'border-b', 'border-slate-200', 'dark:border-slate-800/80');
      navbar.classList.remove('border-transparent');
    } else {
      navbar.classList.remove('shadow-sm', 'border-b', 'border-slate-200', 'dark:border-slate-800/80');
      navbar.classList.add('border-transparent');
    }
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();
}

/* ==========================================================================
   3. MOBILE NAVIGATION DRAWER & EXPANDABLE SUBMENUS (OUTSIDE HEADER)
   ========================================================================== */
function initMobileNav() {
  const mobileToggleBtn = document.getElementById('mobile-menu-toggle');
  const drawerOverlay = document.getElementById('mobile-drawer-overlay');
  const drawerCloseBtn = document.getElementById('mobile-drawer-close');
  const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
  const mobileSubmenuTriggers = document.querySelectorAll('.mobile-submenu-trigger');

  if (!mobileToggleBtn || !drawerOverlay) return;

  function openDrawer() {
    drawerOverlay.classList.remove('drawer-closed');
    drawerOverlay.classList.add('drawer-open');
    document.body.style.overflow = 'hidden';
    mobileToggleBtn.setAttribute('aria-expanded', 'true');
  }

  function closeDrawer() {
    drawerOverlay.classList.remove('drawer-open');
    drawerOverlay.classList.add('drawer-closed');
    document.body.style.overflow = '';
    mobileToggleBtn.setAttribute('aria-expanded', 'false');
  }

  mobileToggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (drawerOverlay.classList.contains('drawer-open')) {
      closeDrawer();
    } else {
      openDrawer();
    }
  });

  if (drawerCloseBtn) {
    drawerCloseBtn.addEventListener('click', closeDrawer);
  }

  drawerOverlay.addEventListener('click', (e) => {
    if (e.target === drawerOverlay) {
      closeDrawer();
    }
  });

  mobileNavLinks.forEach(link => {
    link.addEventListener('click', closeDrawer);
  });

  // Expandable submenus inside mobile drawer
  mobileSubmenuTriggers.forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-target');
      const targetSubmenu = document.getElementById(targetId);
      const icon = trigger.querySelector('.submenu-arrow-icon');

      if (targetSubmenu) {
        const isExpanded = !targetSubmenu.classList.contains('hidden');
        if (isExpanded) {
          targetSubmenu.classList.add('hidden');
          if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
          targetSubmenu.classList.remove('hidden');
          if (icon) icon.style.transform = 'rotate(180deg)';
        }
      }
    });
  });
}

/* ==========================================================================
   4. HOSTING CATEGORY TABS (SHARED, CLOUD, VPS, BDIX)
   ========================================================================== */
function initHostingTabs() {
  const tabButtons = document.querySelectorAll('.hosting-tab-btn');
  const tabPanels = document.querySelectorAll('.hosting-tab-panel');

  if (!tabButtons.length || !tabPanels.length) return;

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetCategory = btn.getAttribute('data-category');

      // Update button active styles
      tabButtons.forEach(b => {
        b.classList.remove(
          'active-tab',
          'bg-blue-600',
          'text-white',
          'shadow-sm',
          'border-blue-600'
        );
        b.classList.add(
          'text-slate-600',
          'dark:text-slate-400',
          'hover:text-slate-900',
          'dark:hover:text-white',
          'border-transparent'
        );
        b.setAttribute('aria-selected', 'false');
      });

      btn.classList.add(
        'active-tab',
        'bg-blue-600',
        'text-white',
        'shadow-sm',
        'border-blue-600'
      );
      btn.classList.remove(
        'text-slate-600',
        'dark:text-slate-400',
        'hover:text-slate-900',
        'dark:hover:text-white',
        'border-transparent'
      );
      btn.setAttribute('aria-selected', 'true');

      // Toggle tab panel visibility
      tabPanels.forEach(panel => {
        if (panel.id === `panel-${targetCategory}`) {
          panel.classList.remove('hidden');
          panel.classList.add('animate-fadeIn');
        } else {
          panel.classList.add('hidden');
          panel.classList.remove('animate-fadeIn');
        }
      });
    });
  });
}

/* ==========================================================================
   5. MONTHLY / YEARLY BILLING TOGGLE
   ========================================================================== */
function initBillingToggle() {
  const billingToggle = document.getElementById('billing-toggle');
  const monthlyLabels = document.querySelectorAll('.billing-monthly-label');
  const yearlyLabels = document.querySelectorAll('.billing-yearly-label');
  const monthlyPrices = document.querySelectorAll('.price-monthly');
  const yearlyPrices = document.querySelectorAll('.price-yearly');
  const billingPeriods = document.querySelectorAll('.price-period');

  if (!billingToggle) return;

  billingToggle.addEventListener('change', () => {
    const isYearly = billingToggle.checked;

    if (isYearly) {
      monthlyPrices.forEach(el => el.classList.add('hidden'));
      yearlyPrices.forEach(el => el.classList.remove('hidden'));
      billingPeriods.forEach(el => el.textContent = '/yr');

      monthlyLabels.forEach(el => el.classList.remove('text-blue-600', 'font-semibold', 'dark:text-blue-400'));
      monthlyLabels.forEach(el => el.classList.add('text-slate-500', 'font-normal'));

      yearlyLabels.forEach(el => el.classList.add('text-blue-600', 'font-semibold', 'dark:text-blue-400'));
      yearlyLabels.forEach(el => el.classList.remove('text-slate-500', 'font-normal'));
    } else {
      monthlyPrices.forEach(el => el.classList.remove('hidden'));
      yearlyPrices.forEach(el => el.classList.add('hidden'));
      billingPeriods.forEach(el => el.textContent = '/mo');

      monthlyLabels.forEach(el => el.classList.add('text-blue-600', 'font-semibold', 'dark:text-blue-400'));
      monthlyLabels.forEach(el => el.classList.remove('text-slate-500', 'font-normal'));

      yearlyLabels.forEach(el => el.classList.remove('text-blue-600', 'font-semibold', 'dark:text-blue-400'));
      yearlyLabels.forEach(el => el.classList.add('text-slate-500', 'font-normal'));
    }
  });
}

/* ==========================================================================
   6. DOMAIN SEARCH SIMULATION (VANILLA JS ONLY)
   ========================================================================== */
function initDomainSearch() {
  const searchForm = document.getElementById('domain-search-form');
  const searchInput = document.getElementById('domain-search-input');
  const validationMsg = document.getElementById('domain-validation-msg');
  const resultsContainer = document.getElementById('domain-results');
  const searchedNameSpans = document.querySelectorAll('.searched-domain-base');
  const tldPills = document.querySelectorAll('.tld-pill');

  if (!searchForm || !searchInput) return;

  function performSearch(query) {
    const cleanQuery = query.trim().toLowerCase().replace(/^https?:\/\//, '').replace(/\/.*$/, '');

    if (!cleanQuery || cleanQuery.length < 2) {
      if (validationMsg) {
        validationMsg.textContent = 'Please enter a valid domain name (e.g., yourbrand.com)';
        validationMsg.classList.remove('hidden');
      }
      searchInput.focus();
      return;
    }

    if (validationMsg) {
      validationMsg.classList.add('hidden');
    }

    const baseName = cleanQuery.replace(/\.[a-z.]{2,}$/i, '') || cleanQuery;

    searchedNameSpans.forEach(span => {
      span.textContent = baseName;
    });

    if (resultsContainer) {
      resultsContainer.classList.remove('hidden');
      resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  }

  searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
    performSearch(searchInput.value);
  });

  tldPills.forEach(pill => {
    pill.addEventListener('click', () => {
      const ext = pill.getAttribute('data-tld');
      let currentVal = searchInput.value.trim().toLowerCase();
      if (!currentVal) {
        currentVal = 'mycompany';
      }
      const baseName = currentVal.replace(/\.[a-z.]{2,}$/i, '');
      searchInput.value = `${baseName}${ext}`;
      performSearch(searchInput.value);
    });
  });

  const domainCartBtns = document.querySelectorAll('.domain-cart-btn');
  domainCartBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fa-solid fa-check mr-1.5"></i> Selected';
      btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
      btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
      showToast('Domain selected for registration!', 'success');
      setTimeout(() => {
        btn.innerHTML = originalText;
        btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
      }, 3000);
    });
  });
}

/* ==========================================================================
   7. TECHNICAL SPECIFICATIONS MODAL
   ========================================================================== */
function initSpecModal() {
  const modal = document.getElementById('spec-modal');
  const closeBtn = document.getElementById('spec-modal-close');
  const viewDetailBtns = document.querySelectorAll('.view-plan-details-btn');
  const modalPlanTitle = document.getElementById('modal-plan-title');

  if (!modal) return;

  function openModal(planName) {
    if (modalPlanTitle && planName) {
      modalPlanTitle.textContent = planName;
    }
    modal.classList.remove('modal-closed');
    modal.classList.add('modal-open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('modal-open');
    modal.classList.add('modal-closed');
    document.body.style.overflow = '';
  }

  viewDetailBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const planName = btn.getAttribute('data-plan-name') || 'Hosting Plan Specifications';
      openModal(planName);
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  }

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('modal-open')) {
      closeModal();
    }
  });
}

/* ==========================================================================
   8. FAQ ACCORDION (SINGLE ITEM EXPANDED AT A TIME)
   ========================================================================== */
function initFaqAccordion() {
  const accordionItems = document.querySelectorAll('.accordion-item');

  accordionItems.forEach(item => {
    const trigger = item.querySelector('.accordion-trigger');
    if (!trigger) return;

    trigger.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      accordionItems.forEach(otherItem => {
        otherItem.classList.remove('active');
        const otherTrigger = otherItem.querySelector('.accordion-trigger');
        if (otherTrigger) {
          otherTrigger.setAttribute('aria-expanded', 'false');
        }
      });

      if (!isActive) {
        item.classList.add('active');
        trigger.setAttribute('aria-expanded', 'true');
      }
    });
  });
}

/* ==========================================================================
   9. TESTIMONIAL SLIDER (VANILLA JS CAROUSEL)
   ========================================================================== */
function initTestimonialSlider() {
  const slides = document.querySelectorAll('.testimonial-slide');
  const prevBtn = document.getElementById('testimonial-prev');
  const nextBtn = document.getElementById('testimonial-next');
  const dotsContainer = document.getElementById('testimonial-dots');

  if (!slides.length) return;

  let currentIndex = 0;
  const totalSlides = slides.length;
  let autoSlideTimer = null;

  function showSlide(index) {
    if (index < 0) {
      currentIndex = totalSlides - 1;
    } else if (index >= totalSlides) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }

    slides.forEach((slide, i) => {
      if (i === currentIndex) {
        slide.classList.remove('hidden');
        slide.classList.add('opacity-100');
        slide.classList.remove('opacity-0');
      } else {
        slide.classList.add('hidden');
        slide.classList.add('opacity-0');
        slide.classList.remove('opacity-100');
      }
    });

    if (dotsContainer) {
      const dots = dotsContainer.querySelectorAll('.slider-dot');
      dots.forEach((dot, i) => {
        if (i === currentIndex) {
          dot.classList.add('bg-blue-600', 'w-6');
          dot.classList.remove('bg-slate-400', 'dark:bg-slate-700', 'w-2');
        } else {
          dot.classList.remove('bg-blue-600', 'w-6');
          dot.classList.add('bg-slate-400', 'dark:bg-slate-700', 'w-2');
        }
      });
    }
  }

  if (dotsContainer) {
    dotsContainer.innerHTML = '';
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement('button');
      dot.className = `slider-dot h-2 rounded-full transition-all duration-200 ${i === 0 ? 'bg-blue-600 w-6' : 'bg-slate-400 dark:bg-slate-700 w-2'}`;
      dot.setAttribute('aria-label', `Go to review ${i + 1}`);
      dot.addEventListener('click', () => {
        showSlide(i);
        restartAutoSlide();
      });
      dotsContainer.appendChild(dot);
    }
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      showSlide(currentIndex - 1);
      restartAutoSlide();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      showSlide(currentIndex + 1);
      restartAutoSlide();
    });
  }

  function startAutoSlide() {
    autoSlideTimer = setInterval(() => {
      showSlide(currentIndex + 1);
    }, 7000);
  }

  function restartAutoSlide() {
    if (autoSlideTimer) clearInterval(autoSlideTimer);
    startAutoSlide();
  }

  const sliderWrapper = document.getElementById('testimonial-slider-wrapper');
  if (sliderWrapper) {
    sliderWrapper.addEventListener('mouseenter', () => {
      if (autoSlideTimer) clearInterval(autoSlideTimer);
    });
    sliderWrapper.addEventListener('mouseleave', () => {
      startAutoSlide();
    });
  }

  showSlide(0);
  startAutoSlide();
}

/* ==========================================================================
   10. PROMOTIONAL COUNTDOWN TIMER
   ========================================================================== */
function initPromoCountdown() {
  const daysEl = document.getElementById('countdown-days');
  const hoursEl = document.getElementById('countdown-hours');
  const minsEl = document.getElementById('countdown-mins');
  const secsEl = document.getElementById('countdown-secs');

  if (!daysEl || !hoursEl || !minsEl || !secsEl) return;

  const targetDate = new Date();
  targetDate.setDate(targetDate.getDate() + 4);
  targetDate.setHours(23, 59, 59, 0);

  function updateTimer() {
    const now = new Date().getTime();
    const diff = targetDate.getTime() - now;

    if (diff <= 0) {
      daysEl.textContent = '00';
      hoursEl.textContent = '00';
      minsEl.textContent = '00';
      secsEl.textContent = '00';
      return;
    }

    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const s = Math.floor((diff % (1000 * 60)) / 1000);

    daysEl.textContent = String(d).padStart(2, '0');
    hoursEl.textContent = String(h).padStart(2, '0');
    minsEl.textContent = String(m).padStart(2, '0');
    secsEl.textContent = String(s).padStart(2, '0');
  }

  updateTimer();
  setInterval(updateTimer, 1000);
}

/* ==========================================================================
   11. COPY PROMO CODE INTERACTION
   ========================================================================== */
function initCopyPromoCode() {
  const copyBtn = document.getElementById('copy-promo-btn');
  const promoCodeEl = document.getElementById('promo-code-val');

  if (!copyBtn || !promoCodeEl) return;

  copyBtn.addEventListener('click', () => {
    const code = promoCodeEl.textContent.trim();
    if (navigator.clipboard) {
      navigator.clipboard.writeText(code).then(() => {
        showToast(`Promo code "${code}" copied!`, 'success');
        copyBtn.innerHTML = '<i class="fa-solid fa-check text-emerald-400 mr-1.5"></i> Copied';
        setTimeout(() => {
          copyBtn.innerHTML = '<i class="fa-regular fa-copy mr-1.5"></i> Copy';
        }, 2500);
      });
    } else {
      const textarea = document.createElement('textarea');
      textarea.value = code;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
      showToast(`Promo code "${code}" copied!`, 'success');
    }
  });
}

/* ==========================================================================
   12. BACK TO TOP BUTTON
   ========================================================================== */
function initBackToTop() {
  const backToTopBtn = document.getElementById('back-to-top');
  if (!backToTopBtn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      backToTopBtn.classList.remove('hidden-btn');
      backToTopBtn.classList.add('visible-btn');
    } else {
      backToTopBtn.classList.add('hidden-btn');
      backToTopBtn.classList.remove('visible-btn');
    }
  }, { passive: true });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/* ==========================================================================
   13. ORDER & LEGAL TRIGGERS
   ========================================================================== */
function initOrderTriggers() {
  document.querySelectorAll('a[href="#checkout"]').forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      showToast('Configuring hosting server node & provisioning order...', 'success');
    });
  });

  document.querySelectorAll('a[href="#legal"]').forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      showToast('Opening legal and compliance policy documentation...', 'info');
    });
  });
}

/* ==========================================================================
   14. TOAST NOTIFICATION HELPER
   ========================================================================== */
function showToast(message, type = 'info') {
  let toastContainer = document.getElementById('toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none';
    document.body.appendChild(toastContainer);
  }

  const toast = document.createElement('div');
  const iconClass = type === 'success' ? 'fa-circle-check text-emerald-400' : 'fa-circle-info text-blue-400';
  
  toast.className = 'pointer-events-auto flex items-center gap-3 bg-slate-900 border border-slate-700 text-white px-3.5 py-2.5 rounded-lg shadow-lg text-xs transition-all duration-200 transform translate-y-3 opacity-0 font-medium';
  toast.innerHTML = `
    <i class="fa-solid ${iconClass}"></i>
    <span>${message}</span>
  `;

  toastContainer.appendChild(toast);

  requestAnimationFrame(() => {
    toast.classList.remove('translate-y-3', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
  });

  setTimeout(() => {
    toast.classList.add('opacity-0', 'translate-y-2');
    setTimeout(() => {
      if (toast.parentElement) {
        toast.parentElement.removeChild(toast);
      }
    }, 250);
  }, 3000);
}
