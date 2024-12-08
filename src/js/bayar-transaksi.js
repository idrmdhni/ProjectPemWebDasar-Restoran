const totalHargaPesanan = document.getElementById("totalHargaPesanan");
const bayar = document.getElementById("bayar");
const kembalianDisplay = document.getElementById("kembalianDisplay");
const kembalianInput = document.getElementById("kembalianInput");

bayar.addEventListener("input", function () {
  kembalianDisplay.value = (
    parseInt(this.value) - parseInt(totalHargaPesanan.value)
  ).toLocaleString("id-ID", {
    style: "currency",
    currency: "IDR",
  });

  kembalianInput.value =
    parseInt(this.value) - parseInt(totalHargaPesanan.value);
});
