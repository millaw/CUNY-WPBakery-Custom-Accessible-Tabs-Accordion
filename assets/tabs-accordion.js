document.addEventListener('DOMContentLoaded', function () {
  function updateTabsAccordionDisplay() {
    const tabsContainer = document.querySelector('.tabs-container');
    const accordionContainer = document.querySelector('.accordion-container');
    const tabHeaders = document.querySelectorAll('.tab-header-1, .tab-header-2');
    const accordionHeaders = document.querySelectorAll('.accordion-header-1, .accordion-header-2');
    const tabBodies = document.querySelectorAll('.tab-accordion-body-1, .tab-accordion-body-2');

    if (window.innerWidth > 992) {
      // Tabs mode
      if (tabsContainer) {
        tabsContainer.style.display = '';
        tabsContainer.setAttribute('role', 'tablist');
      }
      // if (accordionContainer) accordionContainer.style.display = 'none';
      tabHeaders.forEach((h, i) => {
        h.style.display = '';
        h.setAttribute('role', 'tab');
        h.setAttribute('tabindex', i === 0 ? '0' : '-1');
        h.setAttribute('aria-selected', i === 0 ? 'true' : 'false');
        h.setAttribute('aria-controls', 'tabpanel-' + i);
        h.id = 'tab-' + i;
        if (i === 0) {
          h.classList.add('active');
        } else {
          h.classList.remove('active');
        }
      });
      tabBodies.forEach((b, i) => {
        b.setAttribute('role', 'tabpanel');
        b.setAttribute('aria-labelledby', 'tab-' + i);
        b.setAttribute('id', 'tabpanel-' + i);
        if (i === 0) {
          b.style.display = '';
          b.setAttribute('aria-hidden', 'false');
        } else {
          b.style.display = 'none';
          b.setAttribute('aria-hidden', 'true');
        }
      });
      accordionHeaders.forEach(h => h.style.display = 'none');
    } else {
      // Accordion mode
      if (tabsContainer) tabsContainer.style.display = 'none';
      if (accordionContainer) accordionContainer.style.display = '';
      tabHeaders.forEach(h => h.style.display = 'none');
      accordionHeaders.forEach((h, i) => {
        h.style.display = '';
        h.setAttribute('role', 'button');
        h.setAttribute('tabindex', '0');
        h.setAttribute('aria-controls', 'accordionpanel-' + i);
        h.id = 'accordionheader-' + i;
        h.setAttribute('aria-expanded', 'false');
      });
      tabBodies.forEach((b, i) => {
        b.setAttribute('role', 'region');
        b.setAttribute('aria-labelledby', 'accordionheader-' + i);
        b.setAttribute('id', 'accordionpanel-' + i);
        if (i === 0) {
          b.style.display = '';
          b.setAttribute('aria-hidden', 'false');
        } else {
          b.style.display = 'none';
          b.setAttribute('aria-hidden', 'true');
        }
      });
    }
  }

  window.addEventListener('resize', updateTabsAccordionDisplay);
  updateTabsAccordionDisplay();

  // Tabs click logic (for >992px)
  const tabHeaders = document.querySelectorAll('.tab-header-1, .tab-header-2');
  const tabBodies = document.querySelectorAll('.tab-accordion-body-1, .tab-accordion-body-2');
  tabHeaders.forEach((tab, idx) => {
    tab.addEventListener('click', function () {
      tabHeaders.forEach((t, i) => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
        t.setAttribute('tabindex', '-1');
        tabBodies[i].style.display = 'none';
        tabBodies[i].setAttribute('aria-hidden', 'true');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      tab.setAttribute('tabindex', '0');
      if (tabBodies[idx]) {
        tabBodies[idx].style.display = '';
        tabBodies[idx].setAttribute('aria-hidden', 'false');
      }
      tab.focus();
    });
    tab.addEventListener('keydown', function (e) {
      let newIdx;
      if (e.key === 'ArrowRight') newIdx = (idx + 1) % tabHeaders.length;
      else if (e.key === 'ArrowLeft') newIdx = (idx - 1 + tabHeaders.length) % tabHeaders.length;
      else if (e.key === 'Home') newIdx = 0;
      else if (e.key === 'End') newIdx = tabHeaders.length - 1;
      if (newIdx !== undefined) {
        e.preventDefault();
        tabHeaders[newIdx].click();
        tabHeaders[newIdx].focus();
      }
    });
  });

  // Accordion click logic (for <=992px)
  const accordionHeaders = document.querySelectorAll('.accordion-header-1, .accordion-header-2');
  // const accordionBodies = document.querySelectorAll('.accordion-body-1, .accordion-body-2');
  const accordionBodies = document.querySelectorAll('.tab-accordion-body-1, .tab-accordion-body-2');
  accordionHeaders.forEach((header, idx) => {
    // Ensure headers are focusable
    header.setAttribute('tabindex', '0');
    header.addEventListener('click', function () {
      // Close all other sections
      accordionHeaders.forEach((h, i) => {
        h.setAttribute('aria-expanded', 'false');
        accordionBodies[i].setAttribute('aria-hidden', 'true');
        accordionBodies[i].style.display = 'none';
      });
      // Open this section
      header.setAttribute('aria-expanded', 'true');
      accordionBodies[idx].setAttribute('aria-hidden', 'false');
      accordionBodies[idx].style.display = '';
      header.focus();
    });
    header.addEventListener('keydown', function (e) {
      let newIdx;
      if (e.key === 'ArrowDown') newIdx = (idx + 1) % accordionHeaders.length;
      else if (e.key === 'ArrowUp') newIdx = (idx - 1 + accordionHeaders.length) % accordionHeaders.length;
      else if (e.key === 'Home') newIdx = 0;
      else if (e.key === 'End') newIdx = accordionHeaders.length - 1;
      if (newIdx !== undefined) {
        e.preventDefault();
        accordionHeaders[newIdx].focus();
        accordionHeaders[newIdx].scrollIntoView({block: 'nearest'});
      } else if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        header.click();
        header.focus();
      }
    });
  });
});
