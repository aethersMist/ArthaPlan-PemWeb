    <x-app-layout>
    <div class="p-6 flex-1 mt-[85px] sm:mt-[62px]">
      <div
        class="flex flex-col gap-4 justify-between items-center w-full overflow-hidden"
      >
        <!-- Item 1 -->
        <div class="flex justify-between items-center w-full">
          <h2
            class="text-xl p-4 font-bold text-center text-light bg-primary uppercase rounded-lg shadow-lg w-full"
          >
            laporan Pemasukkan
          </h2>
        </div>
        <div
          class="w-full grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2"
        >
          <!-- Laporan -->

          <!-- line chart Pemasukan -->
          <section class="rounded-2xl bg-light shadow-lg p-4 w-full">
            <div class="w-full md:w-1/2 gap-2">
              <div
                class="flex-row md:flex justify-center items-center gap-2 mb-4 text-center font-medium text-dark bg-accent uppercase rounded-lg p-2 shadow-lg"
              >
                <p>total Pemasukkan</p>

                <h2 id="totalPemasukkan" class="font-bold"></h2>
              </div>
              <div
                id="lineChartPemasukkan"
                class="bg-base p-4 rounded-lg"
              ></div>
            </div>
          </section>
          <!-- line chart -->

          <!-- pie chart-->
          <section class="rounded-2xl bg-light shadow-lg p-4">
            <div class="w-full md:w-1/2">
              <div class="w-full md:w-1/2 gap-2">
                <h2
                  class="mb-4 text-center font-bold text-primary-dark bg-accent uppercase rounded-lg p-2 shadow-lg"
                >
                  Rincian Kategori Pemasukan
                </h2>
                <!-- Pie chart -->
                <div id="pieChartPemasukkan"></div>
              </div>

              <!-- Legenda -->
              <div
                class="flex justify-between items-center mt-4 text-sm md:text-lg w-full bg-base rounded-xl p-4 h-full"
              >
                <ul class="flex flex-col gap-y-4 w-full">
                  <!-- Gaji -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-briefcase text-accent"
                          aria-hidden="true"
                        ></i>
                        <span>Gaji</span>
                      </div>
                      <p>Rp 50.000</p>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-accent"
                        style="width: 50%"
                      ></div>
                    </div>
                  </li>

                  <!-- Bonus -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-gift text-accent"
                          aria-hidden="true"
                        ></i>
                        <span>Bonus</span>
                      </div>
                      <p>Rp 15.000</p>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-accent"
                        style="width: 15%"
                      ></div>
                    </div>
                  </li>

                  <!-- Hasil Jual -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-sack-dollar text-accent"
                          aria-hidden="true"
                        ></i>
                        <span>Hasil Jual</span>
                      </div>
                      <p>Rp 5.000</p>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-accent"
                        style="width: 5%"
                      ></div>
                    </div>
                  </li>

                  <!-- Lainnya -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-cart-plus text-accent"
                          aria-hidden="true"
                        ></i>
                        <span>Lainnya</span>
                      </div>
                      <p>Rp 3.000</p>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-accent"
                        style="width: 3%"
                      ></div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
        </div>

        <!-- Item 4 -->
        <div class="sm:flex justify-between items-center gap-4 w-full">
          <h2
            class="text-xl p-4 font-bold text-center text-light bg-danger-dark rounded-lg shadow-lg uppercase w-full"
          >
            laporan pengeluaran
          </h2>
        </div>

        <!-- Item 5 & 6 -->
        <div
          class="w-full grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2"
        >
          <!-- line chart Pengeluaran -->
          <section class="rounded-2xl bg-light shadow-lg p-6">
            <div class="w-full md:w-1/2 gap-2">
              <div
                class="flex-row md:flex justify-center items-center gap-2 mb-4 text-center font-medium text-light bg-danger uppercase rounded-lg p-2 shadow-lg"
              >
                <p>total pengeluaran:</p>

                <h2 id="totalPengeluaran" class="font-bold"></h2>
              </div>

              <div
                id="lineChartPengeluaran"
                class="bg-base p-4 rounded-lg"
              ></div>
            </div>
          </section>
          <!-- end line chart -->

          <!-- piechart-->
          <section class="rounded-2xl bg-light shadow-lg p-4">
            <div class="w-full md:w-1/2">
              <div class="w-full md:w-1/2">
                <h2
                  class="mb-4 text-center font-bold text-light bg-danger uppercase rounded-lg p-2 shadow-lg"
                >
                  Rincian Kategori Pengeluaran
                </h2>
                <!-- Pie chart -->
                <div id="pieChartPengeluaran"></div>
              </div>

              <!-- Legenda -->
              <div
                class="flex justify-between items-center mt-4 text-sm md:text-lg w-full bg-base rounded-xl p-4 h-full"
              >
                <ul class="flex flex-col gap-y-4 w-full">
                  <!-- Makan -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-utensils text-danger"
                          aria-hidden="true"
                        ></i>
                        <span>Makan</span>
                      </div>
                      <p>Rp47.000</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-danger"
                        style="width: 61.8%"
                      ></div>
                    </div>
                  </li>

                  <!-- Laundry -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-jug-detergent text-danger"
                          aria-hidden="true"
                        ></i>
                        <span>Laundry</span>
                      </div>
                      <p>Rp11.000</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-danger"
                        style="width: 14.5%"
                      ></div>
                    </div>
                  </li>

                  <!-- Sayuran -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-carrot text-danger"
                          aria-hidden="true"
                        ></i>
                        <span>Sayuran</span>
                      </div>
                      <p>Rp11.000</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-danger"
                        style="width: 14.5%"
                      ></div>
                    </div>
                  </li>

                  <!-- Lainnya -->
                  <li>
                    <div
                      class="flex justify-between items-center w-full text-sm font-semibold text-dark mb-1"
                    >
                      <div class="flex items-center gap-2">
                        <i
                          class="fa fa-lg fa-cart-plus text-danger"
                          aria-hidden="true"
                        ></i>
                        <span>Lainnya</span>
                      </div>
                      <p>Rp8.000</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div
                        class="h-2 rounded-full bg-danger"
                        style="width: 10.5%"
                      ></div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </section>
          <!-- Laporan Pengeluaran -->
        </div>
      </div>
    </div>
    <!-- Content -->
    </x-app-layout>