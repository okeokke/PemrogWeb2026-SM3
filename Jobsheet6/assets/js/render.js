/**
 * Contoh call:
 *   muatDataTabel("../data/buku.json", ["judul", "pengarang", "tahun", "stok"]);
 *   muatDataTabel("../data/anggota.json", ["no_anggota", "nama", "alamat", "no_hp"]);
 */
async function muatDataTabel(jsonFile, keys, selector) {
    var tbody = document.querySelector(selector || ".table-responsive table tbody");
    var loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    var colspan = keys.length + 1; // kolom data + kolom aksi (edit/eapus)

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi delay jaringan agar loading terlihat
        await new Promise(function (resolve) {
            setTimeout(resolve, 600);
        });
        var res = await fetch(jsonFile);
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        var dataList = await res.json();

        dataList.forEach(function (item) {
            var tr = document.createElement("tr");
            // Bangun cell data berdasarkan daftar keys
            var cells = "";
            for (var i = 0; i < keys.length; i++) {
                cells += "<td>" + item[keys[i]] + "</td>";
            }
            // kolom aksi
            cells +=
                "<td>" +
                '<button type="button">Edit</button> ' +
                '<button type="button" class="btn-hapus">Hapus</button>' +
                "</td>";
            tr.innerHTML = cells;
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            '<tr><td colspan="' +
            colspan +
            '">Gagal memuat data: ' +
            err.message +
            "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}
