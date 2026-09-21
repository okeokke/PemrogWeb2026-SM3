// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
      console.log(e.target) 
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
        }
    });
}

function tableCounter() {
    const counter=document.getElementById("table-counter");
    const table=document.querySelector(".table-responsive table");
    if (!counter || !table) return;

    const allRows=table.querySelectorAll("tbody tr");
    const visibleRows=table.querySelectorAll('tbody tr:not([style*="display: none"])');
    const total=allRows.length;
    const visible=visibleRows.length;

    counter.textContent="Menampilkan "+visible+" dari "+total+" buku";
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            const mainCell=row.querySelector("td");
            const mainText=mainCell?mainCell.textContent.toLowerCase() : "";
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
        tableCounter();
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

const aturanValidasi = [
    {
        selector: "[name='judul'], [name='nama']",
        message: "Field ini wajib diisi.",
        validate: function (value) {
            return value.trim()!=="";
        }
    },
    {
        selector: "[name='pengarang']",
        message: "Pengarang wajib diisi.",
        validate: function (value) {
            return value.trim()!=="";
        }
    },
    {
        selector: "[name='tahun']",
        message: "Tahun harus di antara 1900-2026.",
        validate: function (value) {
            var n = parseInt(value, 10);
            return !isNaN(n) && n>=1900 && n<=2026;
        }
    },
    {
        selector: "[name='stok']",
        message: "Stok tidak boleh negatif.",
        validate: function (value) {
            var n = parseInt(value, 10);
            return !isNaN(n) && n>=0;
        }
    },
    {
        selector: "[name='isbn']",
        message: "Hanya masukkan angka dan tanda hubung.",
        validate: function (value) {
            return /^\d+(-\d+)*$/.test(value);
        }
    }
];

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        aturanValidasi.forEach(function (rule) {
            const input = form.querySelector(rule.selector);
            if (input && !rule.validate(input.value)) {
                tampilkanError(input, rule.message);
                valid = false;
            } else if (input) {
                hapusError(input);
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    tableCounter();
});