window.addEventListener("scroll", function () {
    const nav = document.querySelector(".nav");
    if (window.scrollY > 0) {
      nav.classList.add("shadow");
    } else {
      nav.classList.remove("shadow");
    }
  });

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

    function adjustQty(button, change) {
  const input = button.parentElement.querySelector('input');
  let current = parseInt(input.value) || 0;
  let newQty = current + change;

  // Batas bawah = 0
  if (newQty < 0) newQty = 0;

  input.value = newQty;
}

function showToast(message = "Produk berhasil ditambahkan!") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
  }, 2000);
}

function addToCart(e, productId, formElement) {
  e.preventDefault();
  const quantity = formElement.querySelector('input[name="quantity"]').value;

  if (quantity < 100) {
    showToast("Minimal 100 pcs ya!");
    return;
  }

  fetch("../perintah/add_to_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `product_id=${productId}&quantity=${quantity}`
  })
  .then(res => res.text())
  .then(data => {
    showToast("Produk berhasil ditambahkan!");
    console.log("Respon:", data);
  })
  .catch(() => {
    showToast("Gagal menambahkan. Coba lagi!");
  });
}