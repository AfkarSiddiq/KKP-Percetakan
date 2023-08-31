<div class="col-lg-12">
    <div class="card mb-12">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Bahan Paling banyak habis 1 bulan terakhir(Meter)
        </div>

        <!-- Bar Chart -->
        <div class="card-body">
            <canvas id="Stokbarang" width="100%" height="50"></canvas>

            <script>
                // ambil data nama nama dan stok dari DashboardController di fungsi index
                var lbl = [
                    @foreach ($ar_stok as $s)
                        '{{ $s->nama_bahan }}',
                    @endforeach
                ];
                var stk = [
                    @foreach ($ar_stok as $s)
                        '{{ $s->jumlah }}',
                    @endforeach
                ];
                document.addEventListener("DOMContentLoaded", () => {
                    new Chart(document.getElementById('Stokbarang'), {
                        type: 'bar',
                        data: {
                            labels: lbl,
                            datasets: [{
                                label: 'Bahan paling banyak habis dalam bulan ini',
                                data: stk,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

        <!-- End Bar Chart -->
    </div>
</div>
