// navbar
window.addEventListener("scroll", function () {
    const nav = document.querySelector(".nav");
    if (window.scrollY > 0) {
      nav.classList.add("shadow");
    } else {
      nav.classList.remove("shadow");
    }
  });
  // navbar

  // Inspirasi bisnis
function showContent(id) {
      // Sembunyikan semua tab
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });

      // Tampilkan yang dipilih
      document.getElementById(id).classList.add('active');

      // Atur tombol aktif
      document.querySelectorAll('.menu button').forEach(btn => {
        btn.classList.remove('active');
      });
      const activeBtn = Array.from(document.querySelectorAll('.menu button')).find(btn =>
        btn.innerText.replace(/\s/g, '').toLowerCase().includes(id)
      );
      if (activeBtn) activeBtn.classList.add('active');
    }

    function toggleSub(el) {
      // toggle class 'active' untuk menampilkan subcategory
      el.classList.toggle("active");
    }
// inspirasi bisnis