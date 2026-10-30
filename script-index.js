// ===== تبديل اللغة =====
document.querySelector('.lang-btn')?.addEventListener('click', () => {
  const isAr = document.documentElement.lang !== 'en';
  const newLang = isAr ? 'en' : 'ar';

  // تغيير اتجاه الصفحة
  document.documentElement.lang = newLang;
  document.documentElement.dir  = isAr ? 'ltr' : 'rtl';
  document.querySelector('.lang-btn').textContent = isAr ? 'عر' : 'EN';

  // تغيير كل النصوص
  document.querySelectorAll('[data-ar][data-en]').forEach((el) => {
    if (el.tagName === 'INPUT') {
      el.placeholder = el.dataset[newLang];
    } else {
      el.textContent = el.dataset[newLang];
    }
  });

  // إعادة ربط أزرار الهيدر بعد تغيير النص
  document.querySelectorAll('header button').forEach((btn) => {
    const ar = btn.dataset.ar;
    if (ar === 'تسجيل دخول') btn.onclick = () => openModal('login');
    if (ar === 'إنشاء حساب') btn.onclick = () => openModal('register');
  });
});

// ===== Header يتغير عند التمرير =====
window.addEventListener('scroll', () => {
  const header = document.querySelector('header');
  header.style.boxShadow = window.scrollY > 10
    ? '0 2px 12px rgba(0,0,0,0.1)'
    : '2px 2px 4px rgb(253,253,253)';
});



// ===== Toast إشعار =====
function showToast(msg) {
  const toast = document.createElement('div');
  toast.textContent = msg;
  toast.style.cssText = `
    position:fixed; bottom:30px; left:50%; transform:translateX(-50%);
    background:#0C4B53; color:#fff; padding:12px 24px;
    border-radius:20px; font-family:'Cairo',sans-serif;
    z-index:9999; font-size:14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  `;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

// ===== أزرار الهيدر =====
document.querySelectorAll('header button').forEach((btn) => {
  const text = btn.textContent.trim();
  if (text === 'تسجيل دخول') btn.addEventListener('click', () => openModal('login'));
  if (text === 'إنشاء حساب') btn.addEventListener('click', () => openModal('register'));
});

// ===== Modal =====
function openModal(type) {
  let modal = document.getElementById(`${type}-modal`);

  if (!modal) {
    modal = document.createElement('div');
    modal.id = `${type}-modal`;
    modal.style.cssText = `
      position:fixed; inset:0; background:rgba(0,0,0,0.5);
      display:flex; align-items:center; justify-content:center; z-index:999;
    `;

    modal.innerHTML = `
      <div style="background:#fff; padding:32px; border-radius:16px; width:320px; 
                  text-align:center; direction:rtl; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="color:#0C4B53; margin-bottom:20px; font-family:'Cairo',sans-serif;">
          ${type === 'login' ? 'تسجيل الدخول' : 'إنشاء حساب'}
        </h3>
        ${type === 'register' ? `
          <input placeholder="الاسم" 
            style="width:100%;padding:10px;margin-bottom:12px;border-radius:10px;
                   border:1px solid #CDECEF;box-sizing:border-box;"><br>
        ` : ''}
        <input type="email" placeholder="البريد الإلكتروني" 
          style="width:100%;padding:10px;margin-bottom:12px;border-radius:10px;
                 border:1px solid #CDECEF;box-sizing:border-box;"><br>
        <input type="password" placeholder="كلمة المرور" 
          style="width:100%;padding:10px;margin-bottom:20px;border-radius:10px;
                 border:1px solid #CDECEF;box-sizing:border-box;"><br>
        <button onclick="handleSubmit('${type}')"
          style="background:#44969F;color:#fff;border:none;padding:10px 30px;
                 border-radius:20px;cursor:pointer;font-family:'Cairo',sans-serif;">
          ${type === 'login' ? 'دخول' : 'إنشاء'}
        </button>
        <button onclick="document.getElementById('${type}-modal').remove()"
          style="background:none;border:none;color:#999;margin-top:10px;
                 cursor:pointer;display:block;width:100%;font-family:'Cairo',sans-serif;">
          إلغاء
        </button>
      </div>
    `;

    document.body.appendChild(modal);

    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.remove();
    });
  }
}

// ===== التحقق من البيانات =====
function handleSubmit(type) {
  const modal = document.getElementById(`${type}-modal`);
  const inputs = modal.querySelectorAll('input');

  const email    = type === 'login' ? inputs[0].value : inputs[1].value;
  const password = type === 'login' ? inputs[1].value : inputs[2].value;

  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(email)) {
    showToast(' البريد الإلكتروني غير صحيح!');
    return;
  }

  if (password.length < 6) {
    showToast(' كلمة المرور يجب أن تكون 6 أحرف على الأقل!');
    return;
  }

  showToast(type === 'login' ? 'تم تسجيل الدخول بنجاح' : ' تم إنشاء الحساب بنجاح');
  modal.remove();
}

// ===== Smooth Scroll =====
document.querySelectorAll('a[href^="#"]').forEach((a) => {
  a.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelector(a.getAttribute('href'))
      ?.scrollIntoView({ behavior: 'smooth' });
  });
});