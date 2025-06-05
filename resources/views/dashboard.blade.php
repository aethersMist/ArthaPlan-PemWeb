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

      <!-- Card Section -->
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
        <!-- Anggaran -->
        <section class="rounded-2xl bg-light shadow-lg p-6">
          <!-- Judul -->
            <a href="{{ route('budgets') }}">
          <div class="flex items-center mb-4 gap-2">
            <div class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg">
              <i class="fa-solid fa-table fa-md"></i>
            </div>
            <h2 class="text-lg font-semibold">Anggaran</h2>
          </div>
            </a>

          <!-- Konten Utama -->
          <div class="flex flex-col lg:flex-row w-full gap-4 lg:gap-6 items-center lg:items-center justify-between">
            <!-- Chart -->
            <div class="w-full lg:w-2/5 flex justify-center bg-base rounded-xl py-4">
              <div id="donutChartPersen" data-sisa="{{ $persenSisa }}" data-pakai="{{ $persenPakai }}"></div>
            </div>

            <!-- Informasi Anggaran -->
            <div class="w-full lg:w-3/5 space-y-4 text-md sm:text-sm lg:text-lg">
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Anggaran</p>
                <p class="text-right">360.000</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="lightspace-nowrap">Sisa</p>
                <div class="flex gap-1 items-center text-right">
                  <span class="text-accent text-sm">(60%)</span>
                  <p>220.000</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Riwayat Transaksi -->
        <section class="rounded-2xl bg-light shadow-lg p-4">
            <a href="{{ route('transactions') }}">

          <div class="flex items-center mb-4 gap-2">
            <div class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg">
              <i class="fa fa-file-lines fa-md" aria-hidden="true"></i>
            </div>
            <h2 class="text-lg font-semibold">Riwayat Transaksi</h2>
          </div></a>
          <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full text-sm lg:text-md text-left text-gray-700">
              <thead class="text-sm lg:text-md text-primary-dark uppercase bg-accent">
                <tr>
                  <th class="px-4 py-3">No.</th>
                  <th class="px-4 py-3">Kategori</th>
                  <th class="px-4 py-3">Keterangan</th>
                  <th class="px-4 py-3">Tanggal</th>
                  <th class="px-4 py-3">Nominal</th>
                  <th class="px-4 py-3">Action</th>
                </tr>
              </thead>
              <tbody class="bg-light divide-y divide-gray-200">
                    @forelse($transactions as $index => $transaction)
                            <tr>
                            <td class="px-4 py-4">{{ $index + 1 }}</td>
                            <td class="px-4 py-4">
                                <div class="flex justify-start items-center">
                                <span class="text-center px-2 py-1 w-full bg-primary text-light font-medium rounded-lg">
                                    {{ $transaction->category }}
                                </span>
                                </div>
                            </td>
                            <td class="px-4 py-4">{{ $transaction->description }}</td>
                            <td class="px-4 py-4">{{ $transaction->transaction_date->translatedFormat('l, d F Y') }}</td>
                            <td class="px-4 py-4">
                                <div class="flex justify-start items-center gap-1 text-sm lg:text-lg">
                                <span class="{{ $transaction->type == 'in' ? 'text-accent' : 'text-danger' }}">
                                    <i class="fa fa-{{ $transaction->type == 'in' ? 'plus' : 'minus' }}" aria-hidden="true"></i>
                                </span>
                                <p>Rp{{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                </div>
                            </td>
                            <td class="flex gap-2 px-4 py-4">
                                <!-- Tombol Edit -->
                                <x-primary-button data-modal-target="editRiwayat-{{ $transaction->id }}"
                                        data-modal-toggle="editRiwayat-{{ $transaction->id }}"
                                        type="button"
                                        class="flex justify-center items-center h-8 w-8 bg-accent text-light rounded-full hover:bg-primary transition duration-300 ease-in-out">
                                <i class="fa fa-edit"></i>
                                </x-primary-button>

                                <!-- Tombol Hapus -->
                                <x-secondary-button data-modal-target="deleteAlertRiwayat-{{ $transaction->id }}"
                                        data-modal-toggle="deleteAlertRiwayat-{{ $transaction->id }}"
                                        type="button"
                                        class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full hover:bg-accent transition duration-300 ease-in-out">
                                <i class="fa fa-trash"></i>
                                </x-secondary-button>
                            </td>
                            </tr>

                            @empty
                    <tr>
                        <td colspan="6" class="w-full text-center py-4 text-md text-dark font-medium bg-light">
                        Tidak ada data transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
          </div>
        </section>

        <!-- Laporan (Pie Chart) -->
        <section class="rounded-2xl bg-light shadow-lg p-6">
          <!-- Header Laporan -->
            <a href="{{ route('reports') }}">

          <div class="flex items-center mb-4 gap-2">
            <div class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg">
              <i class="fa fa-chart-pie fa-md"></i>
            </div>
            <h2 class="text-lg font-semibold">Laporan</h2>
          </div>
            </a>

          <!-- Chart dan Legenda -->
          <div class="space-y-4 lg:space-y-0 lg:flex gap-4 items-center justify-center">
            <!-- Donut Chart -->
            <div class="flex items-center justify-center w-full lg:w-1/2">
                <div id="pie-chart-Income"
                    data-categories='@json($categories)'
                    data-values='@json($values)'>
                </div>
              </div>

            <!-- Legenda -->
            <div class="flex justify-center items-center mt-4 text-sm md:text-lg w-full bg-base rounded-xl p-4 h-full">
              <ul id="legend-Dashboard" class="flex flex-wrap gap-x-6 gap-y-2 space-x-4">
                </ul>
            </div>
          </div>
        </section>

        <!-- Diagram (Bar Chart) -->
        <section class="flex flex-col rounded-2xl bg-light shadow-lg p-6">
          <!-- atas -->
          <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
              <div
                class="flex justify-center items-center h-8 w-8 bg-primary text-light rounded-full cursor-pointer hover:bg-accent shadow-lg"
              >
                <i class="fa-solid fa-chart-simple fa-md"></i>
              </div>
              <h2 class="text-lg font-semibold">Diagram</h2>
            </div>
            <!-- Dropdown -->
            <x-dropdown align="right" width="auto">
                    <x-slot name="trigger">
                        <x-secondary-button class="text-sm rounded-lg px-1.5 py-[1px] gap-1">
                    {{ ucfirst($filter ?? 'bulan') }}
                    <i class="fa-solid fa-chevron-down"></i>
                </x-secondary-button>
                    </x-slot>

                    <x-slot name="content">
                      <div class="space-y-1 p-1 rounded-lg text-sm text-dark">
                          @foreach(['tahun', 'bulan', 'minggu', 'hari'] as $option)
                            <button
                                type="button"
                                data-filter="{{ $option }}"
                                class="w-full text-left px-3 py-1.5 hover:bg-gray-100 {{ ($filter ?? 'bulan') === $option ? 'font-bold bg-gray-200 rounded' : '' }}">
                                {{ ucfirst($option) }}
                            </button>
                        @endforeach

                      </div>
                  </x-slot>

                </x-dropdown>
          </div>
          <!-- body Diagram -->
          <div class="space-y-4">
            <div class="flex justify-between items-center text-sm lg:text-lg">
              <p>
                Rata-rata: <span>Rp{{ number_format($rataRata, 2, ',', '.') }}</span></p>
            </div>
            <div
              class="bg-gradient-to-t from-accent to-base rounded-xl h-auto flex items-center justify-center text-light p-4"
            >
              <canvas id="barChartCanvas"
                    data-labels='@json($labels)'
                    data-data-out='@json($dataOut)'
                    data-data-in='@json($dataIn)'>
            </canvas>
            </div>
          </div>
        </section>
        <!-- end diagram card  -->

      </div>
    </div>
    <!-- Content -->

    <!-- Semua Modal -->
    @foreach($transactions as $transaction)
      <!-- Modal Hapus -->
      <x-moddal id="deleteAlertRiwayat-{{ $transaction->id }}" title="Hapus Data" :name="'Hapus'">
        <div class="mb-6 text-dark">
          Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
        </div>
        <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}" class="flex justify-end gap-2">
          @csrf
          @method('DELETE')
          <x-danger-button type="submit" class="rounded-lg px-4 py-2">
                Hapus
            </x-danger-button>
        </form>
      </x-moddal>

      <!-- Modal Edit -->
      <x-moddal id="editRiwayat-{{ $transaction->id }}" title="Update Transaksi" :name="'Update Transaksi'">
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
            <div>
              <label for="category_{{ $transaction->id }}" class="block mb-2 text-sm font-medium text-dark">Kategori</label>
              <input type="text" id="category_{{ $transaction->id }}" name="category" value="{{ $transaction->category }}"
                     required class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
            </div>
            <div>
              <label for="type_{{ $transaction->id }}" class="block mb-2 text-sm font-medium text-dark">Jenis Transaksi</label>
              <select id="type_{{ $transaction->id }}" name="type"
                      class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" required>
                <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>Pemasukan</option>
                <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Pengeluaran</option>
              </select>
            </div>
            <div>
              <label for="amount_{{ $transaction->id }}" class="block mb-2 text-sm font-medium text-dark">Nominal</label>
              <input type="number" id="amount_{{ $transaction->id }}" name="amount" value="{{ $transaction->amount }}"
                     required class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
            </div>
            <div>
              <label for="date_{{ $transaction->id }}" class="block mb-2 text-sm font-medium text-dark">Tanggal</label>
              <input type="date" id="date_{{ $transaction->id }}" name="transaction_date"
                     value="{{ $transaction->transaction_date->translatedFormat('d F Y') }}"
                     required class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
            </div>
            <div class="col-span-2">
              <label for="description_{{ $transaction->id }}" class="block mb-2 text-sm font-medium text-dark">Keterangan</label>
              <textarea id="description_{{ $transaction->id }}" name="description" rows="3"
                        class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg resize-none"
                        required>{{ $transaction->description }}</textarea>
            </div>
          </div>
          <div class="flex items-center justify-end mt-6 gap-2">
            <x-primary-button type="submit" class="rounded-lg px-4 py-2">
                Simpan
            </x-primary-button>
          </div>
        </form>
      </x-moddal>
      @endforeach

</x-app-layout>
