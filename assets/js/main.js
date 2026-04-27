(() => {
  const nav = document.querySelector("[data-nav]");
  const toggle = document.querySelector("[data-nav-toggle]");
  if (nav && toggle) {
    toggle.addEventListener("click", () => {
      const isOpen = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
    });
  }

  const revealEls = Array.from(document.querySelectorAll("[data-reveal]"));
  if ("IntersectionObserver" in window && revealEls.length) {
    const io = new IntersectionObserver(
      (entries) => {
        for (const e of entries) {
          if (e.isIntersecting) {
            e.target.classList.add("is-revealed");
            io.unobserve(e.target);
          }
        }
      },
      { threshold: 0.1 }
    );
    revealEls.forEach((el) => io.observe(el));
  }

  // WhatsApp modal (clean design)
  const waModal = document.querySelector("[data-wa-modal]");
  const waOpen = document.querySelector("[data-wa-open]");
  const waCloseEls = Array.from(document.querySelectorAll("[data-wa-close]"));
  if (waModal && waOpen) {
    const open = () => {
      waModal.classList.add("is-open");
      waModal.setAttribute("aria-hidden", "false");
    };
    const close = () => {
      waModal.classList.remove("is-open");
      waModal.setAttribute("aria-hidden", "true");
    };
    waOpen.addEventListener("click", open);
    waCloseEls.forEach((el) => el.addEventListener("click", close));
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") close();
    });
  }

  // Cart (services checkout)
  const tier = (() => {
    const parts = window.location.pathname.split("/").filter(Boolean);
    // /Bisinis/<tier>/...
    return parts[1] || "root";
  })();
  const CART_KEY = `bisinis_cart_v1:${tier}`;
  const formatIDR = (n) =>
    "Rp " + new Intl.NumberFormat("id-ID").format(Number(n || 0));

  const readCart = () => {
    try {
      const raw = localStorage.getItem(CART_KEY);
      const parsed = raw ? JSON.parse(raw) : {};
      return parsed && typeof parsed === "object" ? parsed : {};
    } catch {
      return {};
    }
  };
  const writeCart = (cart) => {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  };

  const cartCountEl = document.querySelector("[data-cart-count]");
  const cartTotalEl = document.querySelector("[data-cart-total]");
  const cartItemsEl = document.querySelector("[data-cart-items]");
  const cartDrawer = document.querySelector("[data-cart-drawer]");
  const cartOpen = document.querySelector("[data-cart-open]");
  const cartClose = document.querySelector("[data-cart-close]");
  const cartClear = document.querySelector("[data-cart-clear]");
  const cartWA = document.querySelector("[data-cart-wa]");

  const renderCart = () => {
    if (!cartItemsEl || !cartCountEl || !cartTotalEl) return;
    const cart = readCart();
    const items = Object.values(cart);
    const count = items.reduce((a, it) => a + (it.qty || 0), 0);
    const total = items.reduce((a, it) => a + (it.qty || 0) * (it.price || 0), 0);

    cartCountEl.textContent = String(count);
    cartTotalEl.textContent = formatIDR(total);

    if (!items.length) {
      cartItemsEl.innerHTML =
        '<div class="help">Keranjang masih kosong. Klik <strong>Tambah</strong> pada layanan.</div>';
    } else {
      cartItemsEl.innerHTML = items
        .map(
          (it) => `
            <div class="cart-item" data-cart-item="${it.id}">
              <div>
                <div class="cart-item__name">${escapeHtml(it.name)}</div>
                <div class="cart-item__meta">${formatIDR(it.price)} × ${it.qty}</div>
              </div>
              <div class="qty">
                <button type="button" data-qty-minus aria-label="Kurangi">−</button>
                <div class="qty__n">${it.qty}</div>
                <button type="button" data-qty-plus aria-label="Tambah">+</button>
              </div>
            </div>
          `
        )
        .join("");
    }

    if (cartWA) {
      const base = cartWA.getAttribute("href") || "#";
      // If href already wa.me, keep path and override text param
      const lines = items.map(
        (it) => `- ${it.name} x${it.qty} (${formatIDR(it.price)})`
      );
      const msg =
        "Halo, saya mau order layanan berikut (estimasi):\n" +
        lines.join("\n") +
        (lines.length ? `\n\nTotal estimasi: ${formatIDR(total)}` : "");
      const waHref = buildWaHref(base, msg);
      cartWA.setAttribute("href", waHref);
      cartWA.setAttribute("aria-disabled", items.length ? "false" : "true");
    }
  };

  function buildWaHref(existingHref, text) {
    // Prefer wa.me link if present; otherwise just create placeholder "#" (Premium already provides wa.me)
    const msg = encodeURIComponent(text);
    if (existingHref.startsWith("https://wa.me/")) {
      const [base] = existingHref.split("?");
      return `${base}?text=${msg}`;
    }
    return existingHref === "#" ? "#" : existingHref;
  }

  function escapeHtml(s) {
    return String(s)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  document.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-add-to-cart]");
    if (btn) {
      const id = btn.getAttribute("data-id");
      const name = btn.getAttribute("data-name");
      const price = Number(btn.getAttribute("data-price") || 0);
      if (!id || !name) return;

      const cart = readCart();
      const cur = cart[id] || { id, name, price, qty: 0 };
      cur.qty = (cur.qty || 0) + 1;
      cur.price = price;
      cart[id] = cur;
      writeCart(cart);
      renderCart();
      if (cartDrawer) cartDrawer.classList.add("is-open");
      return;
    }

    const itemEl = e.target.closest("[data-cart-item]");
    if (itemEl && (e.target.matches("[data-qty-plus]") || e.target.matches("[data-qty-minus]"))) {
      const id = itemEl.getAttribute("data-cart-item");
      const cart = readCart();
      const cur = cart[id];
      if (!cur) return;
      if (e.target.matches("[data-qty-plus]")) cur.qty += 1;
      if (e.target.matches("[data-qty-minus]")) cur.qty -= 1;
      if (cur.qty <= 0) delete cart[id];
      writeCart(cart);
      renderCart();
      return;
    }

    if (cartOpen && e.target.closest("[data-cart-open]")) {
      cartDrawer?.classList.add("is-open");
      return;
    }
    if (cartClose && e.target.closest("[data-cart-close]")) {
      cartDrawer?.classList.remove("is-open");
      return;
    }
    if (cartClear && e.target.closest("[data-cart-clear]")) {
      writeCart({});
      renderCart();
      return;
    }
  });

  renderCart();
})();

