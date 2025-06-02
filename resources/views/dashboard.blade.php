<x-app-layout>
    <div class="p-4">
        <h1 class="text-xl font-bold">Dashboard</h1>
        <p><strong>Saldo Saat Ini:</strong> Rp {{ number_format($balance, 2, ',', '.') }}</p>
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($income, 2, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($outcome, 2, ',', '.') }}</p>
    </div>
</x-app-layout>
