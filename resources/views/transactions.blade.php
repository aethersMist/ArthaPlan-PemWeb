<x-app-layout>
  <div class="overflow-x-auto rounded-lg">
    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

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

  </div>
</x-app-layout>
