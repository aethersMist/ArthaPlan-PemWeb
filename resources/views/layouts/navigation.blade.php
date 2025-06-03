<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-primary-dark py-2.5 m-4 md:mx-6 max-w-screen-xl:rounded-full rounded-2xl shadow-lg px-4 sm:px-6 md:px-8">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto gap-4 md:gap-2">

        <!-- Hamburger -->
                    <x-primary-button @click="open = !open" class="sm:hidden inline-flex h-8 w-8 rounded-md p-2 ">
            <i class="fa fa-bars fa-lg" :class="{ 'hidden': open, 'inline-flex': !open }"></i>
            <i class="fa-solid fa-xmark" :class="{ 'hidden': !open, 'inline-flex': open }"></i>
        </x-primary-button>

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-2">
            <x-application-logo class="block h-9 w-auto fill-current text-light" />
            <span class="self-center text-xl md:text-lg font-semibold whitespace-nowrap text-light">ArthaPlan</span>
         </a>

        <!-- Navigation Links -->
        <div class="hidden space-x-4 sm:-my-px sm:flex items-center justify-between w-full md:flex sm:w-auto md:order-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Beranda') }}
            </x-nav-link>
            <x-nav-link :href="route('reports')" :active="request()->routeIs('reports')">
                {{ __('Laporan') }}
            </x-nav-link>
            <x-nav-link :href="route('transactions')" :active="request()->routeIs('transactions')">
                {{ __('Riwayat') }}
            </x-nav-link>
            <x-nav-link :href="route('budgets')" :active="request()->routeIs('budgets')">
                {{ __('Anggaran') }}
            </x-nav-link>
        </div>

        <!-- Right Section -->
        <div class="flex items-center md:order-2 space-x-2">

            <!-- Tombol Modal Tambah -->
            
            <x-primary-button data-modal-target="addModal"
                data-modal-toggle="addModal" class="relative flex items-center justify-center rounded-full w-8 h-8">
                <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
            </x-primary-button>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="auto">
                    <x-slot name="trigger">
                        <x-secondary-button class="w-8 h-8 text-sm leading-4 font-medium rounded-full ">
                            <i class="fa fa-user text-light text-md" aria-hidden="true"></i>
                        </x-secondary-button>

                        
                    </x-slot>

                    <x-slot name="content" cla>
                        <div class="mx-1 px-4 py-2 bg-primary rounded-lg">
                            <div class="font-medium text-md text-light">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="space-y-1 p-1 rounded-lg text-sm text-dark">
                            <x-dropdown-link :href="route('profile.edit')" >
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
             <x-responsive-nav-link :href="route('reports')" :active="request()->routeIs('reports')">
                {{ __('Laporan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions')" :active="request()->routeIs('transactions')">
                {{ __('Riwayat') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('budgets')" :active="request()->routeIs('budgets')">
                {{ __('Anggaran') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="w-auto pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-md text-light">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 p-1 rounded-lg text-sm text-dark bg-light">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Modal Tambah Transaksi -->
    <x-moddal id="addModal" title="Transaksi Baru" :name="'Tambah Transaksi'">
      <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
          <div>
            <label for="category" class="block mb-2 text-sm font-medium text-dark">Kategori</label>
            <input type="text" id="category" name="category" placeholder="Makanan" required
                   class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
          </div>
          <div>
            <label for="type" class="block mb-2 text-sm font-medium text-dark">Jenis Transaksi</label>
            <select id="type" name="type" required
                    class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg">
              <option value="" disabled>Pilih Jenis</option>
              <option value="in">Pemasukan</option>
              <option value="out">Pengeluaran</option>
            </select>
          </div>
          <div>
            <label for="amount" class="block mb-2 text-sm font-medium text-dark">Nominal</label>
            <input type="number" id="amount" name="amount" placeholder="100000" required
                   class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
          </div>
          <div>
            <label for="transaction_date" class="block mb-2 text-sm font-medium text-dark">Tanggal</label>
            <input type="date" id="transaction_date" name="transaction_date" required
                   class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg" />
          </div>
          <div class="col-span-2">
            <label for="description" class="block mb-2 text-sm font-medium text-dark">Keterangan</label>
            <textarea id="description" name="description" rows="3"
                      class="block w-full p-2.5 text-sm text-dark bg-gray-50 border border-gray-300 rounded-lg resize-none"
                      placeholder="Keterangan"></textarea>
          </div>
        </div>
        <div class="flex items-center justify-end mt-6 gap-2">
          <x-primary-button type="submit"
                  class="px-4 py-2 text-light bg-accent rounded-lg hover:bg-primary transition duration-300 ease-in-out">
            Simpan
          </x-primary-button>
        </div>
      </form>
    </x-moddal>