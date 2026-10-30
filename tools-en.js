const categories = [
  {
   
    title: '1. Hand & Wrist Tools',
        products: [
            { id: 1, label: 'Thumb & Wrist Brace', img: 't1.jpeg', shop: 'https://shortlink.uk/1uxHK' },
            { id: 2, label: 'Hand & Finger Exercise Web', img: 't2.jpeg', shop: 'https://shop.tiriaqq.com/ar/dbEOwKj' },
            { id: 3, label: 'Flex Bar', img: 't3.jpeg', shop: 'https://shop.tiriaqq.com/ar/Yggnbog' },
        ]
    },
    {
        title: '2. Rehabilitation & Transfer Tools',
        products: [
            { id: 4, label: 'Balance Board for Rehabilitation', img: 't4.jpeg', shop: 'https://shop.tiriaqq.com/ar/OqrYAYD' },
            { id: 5, label: 'Medical Transfer Sheet with Handles', img: 't5.jpeg', shop: 'https://shortlink.uk/1uxI0' },
            { id: 6, label: 'Sliding Sheet for Patient Transfer', img: 't6.jpeg', shop: 'https://shortlink.uk/1uxId' },
        ]
    },
    {
        title: '3. Mobility & Support Tools',
        products: [
            { id: 7, label: 'Foldable Electric Wheelchair', img: 't7.jpeg', shop: 'https://shortlink.uk/1uxIx' },
            { id: 8, label: 'Foldable Aluminum Walking Frame', img: 't8.jpeg', shop: 'https://shortlink.uk/1pd1C' },
            { id: 9, label: 'Medical Arm Support', img: 't9.jpeg', shop: 'https://shortlink.uk/1pd1S' },
        ]
    },
    {
        title: '4. Back & Foot Supports',
        products: [
            { id: 10, label: 'Night Foot Splint', img: 't10.jpeg', shop: 'https://shortlink.uk/1uxJI' },
            { id: 11, label: 'Inflatable Walking Boot for Ankle & Foot', img: 't11.jpeg', shop: 'https://goo.su/f3nzT' },
            { id: 12, label: 'Back Brace for Posture Correction', img: 't12.jpeg', shop: 'https://shortlink.uk/1uxfr' },
        ]
    }
];

const mainEl = document.getElementById('mainContent');

categories.forEach((cat, ci) => {
  const sec = document.createElement('section');
  sec.className = 'category';
  sec.innerHTML = `
    <div class="category-header">
      <div class="cat-pill">${cat.title}</div>
    </div>
    <div class="product-grid" id="grid-${ci}"></div>
  `;
  mainEl.appendChild(sec);

  // ci (category index) makes each grid ID unique
  const grid = sec.querySelector(`#grid-${ci}`);

  cat.products.forEach((prod) => {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.innerHTML = `
      <div class="card-img">
        <!-- المسار بناءً على المجلد المفتوح في الصورة: images/اسم_الصورة.jpeg -->
        <img src="images/${prod.img}" alt="${prod.label}">
        <a class="shop-overlay" href="${prod.shop}" target="_blank">
          <div class="shop-overlay-btn">Shop Now</div>
        </a>
        <button class="heart-btn" onclick="toggleFav(this, ${prod.id})">
          <svg viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </button>
      </div>
      <div class="card-label">${prod.label}</div>
    `;
    grid.appendChild(card);

    // mark heart as active if already saved
    if (window.savedTools && window.savedTools.includes(prod.id)) {
      card.querySelector(".heart-btn").classList.add("active");
    }
  });
});

function toggleFav(btn, id) {
  fetch("add_favorite.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "tool_id=" + id
  })
  .then(res => res.text())
  .then(data => {
    data = data.trim();
    if (data === "added") {
      btn.classList.add("active");
      showToast("Added to favorites ❤️");
    } else if (data === "removed") {
      btn.classList.remove("active");
      showToast("Removed from favorites 💔");
    }
  });
}

function showToast(msg) {
  const t = document.getElementById('toast');
  if(t) {
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
  }
}