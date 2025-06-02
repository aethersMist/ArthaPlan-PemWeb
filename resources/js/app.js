import "./bootstrap";
import Chart from "chart.js/auto";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi chart
    let barChart;

    function initChart(labels, dataOut, dataIn) {
        const ctx = document.getElementById("barChartCanvas").getContext("2d");

        if (barChart) {
            barChart.destroy();
        }

        barChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Pemasukan",
                        data: dataIn,
                        backgroundColor: "#88cf0f",
                        borderRadius: 8,
                        barThickness: 40,
                    },
                    {
                        label: "Pengeluaran",
                        data: dataOut,
                        backgroundColor: "#f87171",
                        borderRadius: 8,
                        barThickness: 40,
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return "Rp" + value.toLocaleString("id-ID");
                            },
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.dataset.label + ": Rp" + context.raw.toLocaleString("id-ID")
                                );
                            },
                        },
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    }
                },
            },
        });
    }


    // Ambil data dari atribut data-canvas
    const canvas = document.getElementById("barChartCanvas");
    const labels = JSON.parse(canvas.getAttribute("data-labels"));
    const dataOut = JSON.parse(canvas.getAttribute("data-data-out"));
    const dataIn = JSON.parse(canvas.getAttribute("data-data-in"));

    // Inisialisasi chart pertama kali
    if (labels.length > 0) {
        initChart(labels, dataOut, dataIn);
    }
    // Handle filter change
    document.querySelectorAll("[data-filter]").forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");

            // Update URL dengan parameter filter
            const url = new URL(window.location.href);
            url.searchParams.set("filter", filter);
            window.location.href = url.toString();
        });
    });

    // Inisialisasi chart pertama kali
    if (initialLabels.length > 0) {
        initChart(initialLabels, initialDataOut, initialDataIn);
    }

    // Fungsi untuk mengambil data terbaru dari server
    async function fetchChartData() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get("filter") || "monthly";
        const date =
            urlParams.get("date") || new Date().toISOString().split("T")[0];

        try {
            const response = await fetch(
                `/dashboard/chart-data?filter=${filter}&date=${date}`
            );
            const data = await response.json();

            if (data.labels && data.labels.length > 0) {
                initChart(data.labels, data.dataOut, data.dataIn);
            }
        } catch (error) {
            console.error("Error fetching chart data:", error);
        }
    }

    // Setup polling untuk update realtime (setiap 5 detik)
    setInterval(fetchChartData, 5000);

    // Handle filter change
    document.querySelectorAll("[data-filter]").forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");
            const url = new URL(window.location.href);
            url.searchParams.set("filter", filter);
            window.location.href = url.toString();
        });
    });

    // Handle perubahan tanggal
    const dateFilter = document.getElementById("dateFilter");
    dateFilter.addEventListener("change", function () {
        const url = new URL(window.location.href);
        url.searchParams.set("date", this.value);
        window.location.href = url.toString();
    });
});
