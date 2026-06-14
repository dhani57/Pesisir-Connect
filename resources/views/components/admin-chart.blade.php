@props(['labels', 'revenue', 'count'])

<div x-data="chartComponent()" x-init="initChart()" class="bg-white p-6 rounded-2xl shadow-sm ring-1 ring-gray-200 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Perkembangan Transaksi (6 Bulan Terakhir)</h3>
        <span class="inline-flex items-center rounded-md bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Bulanan</span>
    </div>
    
    <div id="transaction-chart" class="w-full h-80"></div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chartComponent', () => ({
                initChart() {
                    const options = {
                        series: [{
                            name: 'Nilai Transaksi (GMV)',
                            type: 'column',
                            data: @json($revenue)
                        }, {
                            name: 'Jumlah Transaksi',
                            type: 'line',
                            data: @json($count)
                        }],
                        chart: {
                            height: 320,
                            type: 'line',
                            toolbar: { show: false },
                            fontFamily: 'inherit'
                        },
                        stroke: {
                            width: [0, 4],
                            curve: 'smooth'
                        },
                        colors: ['#0ea5e9', '#f59e0b'],
                        labels: @json($labels),
                        yaxis: [{
                            labels: {
                                formatter: (value) => { 
                                    if(value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                    if(value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                    return 'Rp ' + value.toLocaleString('id-ID'); 
                                },
                                style: { colors: '#64748b' }
                            }
                        }, {
                            opposite: true,
                            labels: {
                                formatter: (value) => { return Math.round(value); },
                                style: { colors: '#64748b' }
                            }
                        }],
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                columnWidth: '35%'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right'
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                        }
                    };

                    // Only render if element exists to avoid duplicate renders in Alpine
                    const chartEl = document.querySelector("#transaction-chart");
                    if (chartEl && !chartEl.classList.contains('apexcharts-canvas')) {
                        const chart = new ApexCharts(chartEl, options);
                        chart.render();
                    }
                }
            }))
        })
    </script>
</div>
