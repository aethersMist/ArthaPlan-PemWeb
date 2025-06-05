    <x-app-layout>
      <div
        class="flex flex-col gap-4 justify-between items-center w-full overflow-hidden"
      >
        {{-- Income --}}
      <div class="flex justify-between items-center w-full">
        {{-- Title --}}
          <h2
            class="text-xl p-4  text-center text-light bg-primary uppercase rounded-lg shadow-lg w-full font-bold"
          >
            laporan Pemasukkan
          </h2>
        </div>


        <div
          class="w-full grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2"
        >

          <!-- line chart -->
          <section class="rounded-2xl bg-light shadow-lg p-4 w-full">
            <div class="w-full gap-2">
              <div
                class="flex-row md:flex justify-between items-center mb-4 text-center font-bold text-light bg-accent uppercase rounded-lg p-2 shadow-lg"
              >
                <p>total pemasukkan</p>

                <x-secondary-button 
                            class="flex justify-center items-center h-8 w-8  rounded-full ">
                      <i class="fa fa-download"></i>
                    </x-secondary-button>

              </div>
              <div
                id="lineChartIncome" 
                class="bg-base p-4 rounded-lg"
              ></div>
            </div>
          </section>
          <!-- line chart -->

          <!-- pie chart-->
          <section class="rounded-2xl bg-light shadow-lg p-4">
            <div class="w-full">
              <div class="w-full gap-2">
                <h2
                  class="mb-4 text-center font-bold text-primary-dark bg-accent uppercase rounded-lg p-2 shadow-lg"
                >
                  Rincian Kategori Pemasukan
                </h2>
                <!-- Pie chart -->
            <div class="flex items-center justify-center w-full">

                    <div id="pie-chart-Income"
                        data-categories='@json($categories)'
                        data-values='@json($values)'>
                    </div>

                </div>
             </div>

              <!-- Legenda -->
              <div
                class="flex justify-between items-center mt-4 text-sm md:text-lg w-full bg-base rounded-xl p-4 h-full">
                <ul id="legend-Report" class="flex flex-col gap-y-4 w-full">
                  
                </ul>
              </div>
            </div>
          </section>
        </div>

        {{-- Outcome --}}
        <div class="sm:flex justify-between items-center gap-4 w-full">
            {{-- title --}}
          <h2
            class="text-xl p-4 font-bold text-center text-light bg-danger-dark rounded-lg shadow-lg uppercase w-full"
          >
            laporan pengeluaran
          </h2>
        </div>

        <div
          class="w-full grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2"
        >
          <!-- line chart Pengeluaran -->
          <section class="rounded-2xl bg-light shadow-lg p-6">
            <div class="w-full gap-2">
              <div
                class="flex-row md:flex justify-between items-center mb-4 text-center font-bold text-light bg-danger uppercase rounded-lg p-2 shadow-lg"
              >
                <p>total pengeluaran</p>

                <x-secondary-button 
                            class="flex justify-center items-center h-8 w-8  rounded-full ">
                      <i class="fa fa-download"></i>
                    </x-secondary-button>

              </div>

              <div
                id="lineChartOutcome" 
                class="bg-base p-4 rounded-lg"
              ></div>
            </div>
          </section>

          <!-- piechart-->
          <section class="rounded-2xl bg-light shadow-lg p-4">
            <div class="w-full">
              <div class="w-full">
                <h2
                  class="mb-4 text-center font-bold text-light bg-danger uppercase rounded-lg p-2 shadow-lg"
                >
                  Rincian Kategori Pengeluaran
                </h2>
               <!-- Pie chart -->
                 <div class="flex items-center justify-center w-full">

                    <div id="pie-chart-Outcome"
                        data-categories-out='@json($categoriesOut)' data-values-out='@json($valuesOut)'>
                    </div>

                </div>
             </div>

              <!-- Legenda -->
              <div
                class="flex justify-between items-center mt-4 text-sm md:text-lg w-full bg-base rounded-xl p-4 h-full">
                <ul id="legend-Report-Outcome" class="flex flex-col gap-y-4 w-full">
                  
                </ul>
              </div>
            </div>
          </section>
        </div>
      </div>
    </x-app-layout>
