<x-app-layout>
       <section class="w-full bg-light shadow-lg rounded-2xl p-6 mb-6 items-center justify-center">
        <!-- Calendar -->
        <div class="flex items-center space-x-2 mb-6">
        <div class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:text-light hover:bg-accent shadow-lg">
            <i class="fa fa-calendar fa-md" aria-hidden="true"></i>
        </div>
        <div class="flex items-center gap-2">
            <p id="tanggal-terpilih" class="text-md font-bold text-dark">
            {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        </div>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Saldo -->
          <div class="flex items-center justify-between p-4 rounded-xl shadow-lg bg-primary text-light">
            <div>
              <p class="text-sm lg:text-lg">Saldo</p>
              <div class="flex items-start gap-1 font-bold">
                <span class="text-sm lg:text-lg">Rp</span>
                <p class="text-2xl">{{ number_format($balance, 2, ',', '.') }}</p>
              </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex md:hidden lg:flex items-center justify-center">
              <i class="fa fa-money-bill text-2xl text-accent"></i>
            </div>
          </div>

          <!-- Pemasukan -->
          <div class="flex items-center justify-between p-4 bg-primary text-light rounded-xl shadow">
            <div>
              <p class="text-sm lg:text-lg">Pemasukan</p>
              <div class="flex items-start gap-1 font-bold">
                <span class="text-sm lg:text-lg">Rp</span>
                <p class="text-2xl">{{ number_format($income, 2, ',', '.') }}</p>
                <span class="text-sm lg:text-lg text-accent">
                  <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex md:hidden lg:flex items-center justify-center">
              <i class="fa-solid fa-heart text-xl text-accent"></i>
            </div>
          </div>

          <!-- Pengeluaran -->
          <div class="flex items-center justify-between p-4 bg-primary text-light rounded-xl shadow">
            <div>
              <p class="text-sm lg:text-lg">Pengeluaran</p>
              <div class="flex items-start gap-1 font-bold">
                <span class="text-sm lg:text-lg">Rp</span>
                <p class="text-2xl">{{ number_format($outcome, 2, ',', '.') }}</p>
                <span class="text-sm lg:text-lg text-danger">
                  <i class="fa fa-arrow-up" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex md:hidden lg:flex items-center justify-center">
              <i class="fa-solid fa-arrow-right-to-bracket text-xl text-accent"></i>
            </div>
          </div>
        </div>
      </section>

      <section class="flex flex-col md:flex-row justify-between items-center w-full bg-light shadow-lg rounded-2xl p-6 mb-6 gap-6">
    <!-- Chart - Sebelah Kiri -->
    <div class="w-full md:w-1/3 flex justify-center items-center bg-base rounded-xl p-4">
        <div id="donutChartPersen" class="relative w-full max-w-[200px]"></div>
    </div>

    <!-- Ringkasan - Sebelah Kanan -->
    <div class="w-full md:w-2/3 grid grid-row-1 md:grid-row-3 gap-4">
        <!-- Anggaran -->
        <div class="flex items-center justify-between p-4 rounded-xl shadow-lg bg-primary text-light">
            <div>
                <p class="text-sm lg:text-lg">Anggaran</p>
                <div class="flex items-start gap-1 font-bold">
                    <span class="text-sm lg:text-lg">Rp</span>
                    <p class="text-2xl"></p>
                    <button
                        type="button"
                        onclick="document.getElementById('modal-nominal-anggaran').classList.remove('hidden')"
                        class="text-sm lg:text-lg text-netral-light"
                    >
                        <i
                            class="fa fa-edit fa-lg hover:text-light cursor-pointer transition duration-300 ease-in-out"
                            aria-hidden="true"
                        ></i>
                    </button>
                </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex items-center justify-center">
                <i class="fa fa-money-bill text-2xl text-accent"></i>
            </div>
        </div>

        <!-- Pengeluaran -->
        <div class="flex items-center justify-between p-4 bg-primary text-light rounded-xl shadow">
            <div>
                <p class="text-sm lg:text-lg">Pengeluaran</p>
                <div class="flex items-start gap-1 font-bold">
                    <span class="text-sm lg:text-lg">Rp</span>
                    <p class="text-2xl"></p>
                </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex items-center justify-center">
                <i class="fa-solid fa-heart text-xl text-accent"></i>
            </div>
        </div>

        <!-- Rata-rata -->
        <div class="flex items-center justify-between p-4 bg-primary text-light rounded-xl shadow">
            <div>
                <p class="text-sm lg:text-lg">Rata-rata</p>
                <div class="flex items-start gap-1 font-bold">
                    <span class="text-sm lg:text-lg">Rp</span>
                    <p class="text-2xl"></p>
                </div>
            </div>
            <div class="h-10 w-10 rounded-full bg-light flex items-center justify-center">
                <i class="fa-solid fa-arrow-right-to-bracket text-xl text-accent"></i>
            </div>
        </div>
    </div>
</section>

      <!-- Card Section -->
      <div
        class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3"
      >
        <!-- Anggaran -->
        <section class="rounded-2xl bg-light shadow-lg p-6">
          <!-- Judul -->
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
              <div
                class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg"
              >
                <i class="fa fa-train fa-md"></i>
              </div>
              <h2 class="text-lg font-semibold">Transportasi</h2>
            </div>
            <button
              type="button"
              onclick="document.getElementById('modal-rincian-anggaran').classList.remove('hidden')"
              class="block px-[7px] rounded-full hover:bg-primary text-primary hover:text-light cursor-pointer transition duration-300 ease-in-out"
            >
              <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
          </div>

          <!-- Konten Utama -->
          <div
            class="flex flex-col lg:flex-row w-full gap-4 lg:gap-6 items-center lg:items-center justify-between"
          >
            <!-- Informasi Anggaran -->
            <div class="w-full space-y-2 text-md sm:text-sm lg:text-lg">
              <!-- Line -->
              <div class="w-full bg-gray-200 rounded-xl p-1">
                <div
                  class="h-4 p-1 flex justify-center items-center text-xs font-medium rounded-full bg-accent"
                  style="width: 80%"
                >
                  80%
                </div>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Anggaran</p>
                <p class="text-right">60.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Pengeluaran</p>
                <p class="text-right">40.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Sisa</p>
                <p class="text-right">20.000</p>
              </div>
            </div>
          </div>
        </section>

        <!-- Game -->
        <section class="rounded-2xl bg-light shadow-lg p-6">
          <!-- Judul -->
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
              <div
                class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg"
              >
                <i class="fa-brands fa-playstation fa-md"></i>
              </div>
              <h2 class="text-lg font-semibold">Game</h2>
            </div>
            <button
              type="button"
              onclick="document.getElementById('modal-rincian-anggaran').classList.remove('hidden')"
              class="px-[7px] rounded-full hover:bg-primary text-primary hover:text-light cursor-pointer transition duration-300 ease-in-out"
            >
              <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
          </div>

          <!-- Konten Utama -->
          <div
            class="flex flex-col lg:flex-row w-full gap-4 lg:gap-6 items-center lg:items-center justify-between"
          >
            <!-- Informasi Anggaran -->
            <div class="w-full space-y-2 text-md sm:text-sm lg:text-lg">
              <!-- Line -->
              <div class="w-full bg-gray-200 rounded-xl p-1">
                <div
                  class="h-4 p-1 flex justify-center items-center text-xs font-medium rounded-full bg-accent"
                  style="width: 50%"
                >
                  50%
                </div>
              </div>

              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Anggaran</p>
                <p class="text-right">100.000</p>
              </div>

              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Pengeluaran</p>
                <p class="text-right">50.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Sisa</p>
                <p class="text-right">50.000</p>
              </div>
            </div>
          </div>
        </section>

        <!-- Makanan -->
        <section class="rounded-2xl bg-light shadow-lg p-6">
          <!-- Judul -->
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
              <div
                class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg"
              >
                <i class="fa fa-utensils fa-md"></i>
              </div>
              <h2 class="text-lg font-semibold">Makanan</h2>
            </div>
            <button
              type="button"
              onclick="document.getElementById('modal-rincian-anggaran').classList.remove('hidden')"
              class="px-[7px] rounded-full hover:bg-primary text-primary hover:text-light cursor-pointer transition duration-300 ease-in-out"
            >
              <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
          </div>

          <!-- Konten Utama -->
          <div
            class="flex flex-col lg:flex-row w-full gap-4 lg:gap-6 items-center lg:items-center justify-between"
          >
            <!-- Informasi Anggaran -->
            <div class="w-full space-y-2 text-md sm:text-sm lg:text-lg">
              <!-- Line -->
              <div class="w-full bg-gray-200 rounded-xl p-1">
                <div
                  class="h-4 p-1 flex justify-center items-center text-xs font-medium rounded-full bg-accent"
                  style="width: 50%"
                >
                  40%
                </div>
              </div>

              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Anggaran</p>
                <p class="text-right">100.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Pengeluaran</p>
                <p class="text-right">40.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Sisa</p>
                <p class="text-right">60.000</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

    
    <!-- Modal Anggaran Baru -->
    <div
      id="modal"
      class="fixed inset-0 z-50 flex items-center justify-center hidden bg-dark/50"
    >
      <div class="relative w-full max-w-md p-2 bg-light rounded-2xl shadow-lg">
        <!-- Header Modal -->
        <div
          class="flex items-center justify-between bg-accent p-4 border-b rounded-t-lg md:p-5"
        >
          <h3 class="text-lg font-semibold text-primary-dark">Anggaran Baru</h3>
          <button onclick="toggleModal()" class="text-dark hover:text-primary">
            <i class="fas fa-xmark"></i>
          </button>
        </div>

        <!-- Body Modal -->
        <form class="p-4 md:p-6">
          <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
            <!-- Kategori -->
            <div class="sm:col-span-1">
              <label
                for="category"
                class="block mb-2 text-sm font-medium text-dark"
                >Kategori</label
              >
              <input
                type="text"
                id="Kategori"
                name="Kategori"
                placeholder="Makanan"
                required
                class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg focus:ring-accent focus:border-accent"
              />
            </div>

            <!-- Nominal -->
            <div class="sm:col-span-1">
              <label
                for="price"
                class="block mb-2 text-sm font-medium text-dark"
                >Nominal</label
              >
              <input
                type="number"
                id="price"
                name="price"
                placeholder="100.000"
                required
                class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg focus:ring-accent focus:border-accent"
              />
            </div>
          </div>

          <!-- Footer Modal -->
          <div class="flex items-center justify-end mt-6 gap-2">
            <!-- Tombol Aksi -->
            <button
              type="button"
              onclick="toggleModal()"
              class="px-4 py-2 text-dark bg-gray-300 rounded-lg hover:bg-gray-400 transition duration-300 ease-in-out"
            >
              Batal
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-light bg-accent rounded-lg hover:bg-primary transition dur</p>ation-300 ease-in-out"
            >
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- End Modal Anggaran baru -->

    <!-- Modal Input Nominal Anggaran -->
    <div
      id="modal-nominal-anggaran"
      class="fixed inset-0 z-50 hidden bg-dark/50 flex items-center justify-center"
    >
      <div class="relative w-full max-w-md p-2 bg-light rounded-2xl shadow-lg">
        <!-- Header Modal -->
        <div
          class="flex items-center justify-between bg-accent p-4 border-b rounded-t-lg md:p-5"
        >
          <h3 class="text-lg font-semibold text-primary-dark">
            Masukkan Nominal Anggaran
          </h3>
          <button
            type="button"
            onclick="document.getElementById('modal-nominal-anggaran').classList.add('hidden')"
            class="text-dark hover:text-primary"
          >
            <i class="fas fa-xmark"></i>
          </button>
        </div>
        <!-- Body Modal -->
        <form class="p-4 md:p-6">
          <div class="mb-4">
            <label
              for="nominal-anggaran"
              class="block mb-2 text-sm font-medium text-dark"
            >
              Nominal Anggaran
            </label>
            <input
              type="number"
              id="nominal-anggaran"
              name="nominal-anggaran"
              placeholder="Masukkan nominal (contoh: 500000)"
              required
              class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg focus:ring-accent focus:border-accent"
            />
          </div>
          <!-- Footer Modal -->
          <div class="flex items-center justify-end mt-6 gap-2">
            <button
              type="button"
              onclick="document.getElementById('modal-nominal-anggaran').classList.add('hidden')"
              class="px-4 py-2 text-dark bg-gray-300 rounded-lg hover:bg-gray-400 transition duration-300 ease-in-out"
            >
              Batal
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-light bg-accent rounded-lg hover:bg-primary transition duration-300 ease-in-out"
            >
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Rincian Anggaran -->
    <div
      id="modal-rincian-anggaran"
      class="fixed inset-0 z-50 hidden bg-dark/50 flex items-center justify-center"
    >
      <div class="relative w-full max-w-xl p-2 bg-light rounded-2xl shadow-lg">
        <!-- Header Modal -->
        <div
          class="flex items-center justify-between bg-accent p-4 border-b rounded-t-lg md:p-5"
        >
          <h3 class="text-lg font-semibold text-primary-dark">
            Rincian Anggaran (Transportasi)
          </h3>
          <button
            type="button"
            onclick="document.getElementById('modal-rincian-anggaran').classList.add('hidden')"
            class="text-dark hover:text-primary"
          >
            <i class="fas fa-xmark"></i>
          </button>
        </div>
        <!-- Body Modal -->
        <div class="p-2 overflow-x-auto">
          <table class="min-w-full text-sm text-left text-dark">
            <thead class="bg-primary text-light">
              <tr>
                <th scope="col" class="px-4 py-2">Kategori</th>
                <th scope="col" class="px-4 py-2">Jam/Tanggal</th>
                <th scope="col" class="px-4 py-2">Nominal</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="px-4 py-2">Transportasi</td>
                <td class="px-4 py-2">10:30 / 02-05-2025</td>
                <td class="px-4 py-4">
                  <div
                    class="flex justify-center items-center gap-1 text-sm lg:text-lg"
                  >
                    <span class="text-sm lg:text-lg text-danger">
                      <i class="fa fa-minus" aria-hidden="true"></i>
                    </span>
                    <p>Rp20.000</p>
                  </div>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-4 py-2">Transportasi</td>
                <td class="px-4 py-2">08:00 / 01-05-2025</td>
                <td class="px-4 py-4">
                  <div
                    class="flex justify-center items-center gap-1 text-sm lg:text-lg"
                  >
                    <span class="text-sm lg:text-lg text-danger">
                      <i class="fa fa-minus" aria-hidden="true"></i>
                    </span>
                    <p>Rp20.000</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Footer Modal -->
        <div class="flex items-center justify-between p-4">
          <!-- act for delete anggaran -->
          <button
            onclick="document.getElementById('modal-delete').classList.remove('hidden')"
            class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full hover:bg-accent transition duration-300 ease-in-out"
          >
            <i class="fa fa-trash"></i>
          </button>

          <!-- close button -->
          <button
            type="button"
            onclick="document.getElementById('modal-rincian-anggaran').classList.add('hidden')"
            class="px-4 py-2 text-dark bg-gray-300 rounded-lg hover:bg-gray-400 transition duration-300 ease-in-out"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>

</x-app-layout>