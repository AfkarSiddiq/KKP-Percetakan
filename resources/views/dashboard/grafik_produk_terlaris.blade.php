<div class="col-lg-12">
    <div class="card mb-12">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            produk terlaris
        </div>

        <!-- Bar Chart -->
        <div class="card-body">
            <canvas id="terlaris" width="100%" height="50"></canvas>

            <script>
                // ambil data nama nama dan terlaris dari DashboardController di fungsi index
                var label = [
                    @foreach($brg_laris as $d)
                    '{{ $d->nama_barang }}',
                    @endforeach
                ];
                var jumlah = [
                    @foreach($brg_laris as $d)
                    '{{ $d -> jumlah }}',
                    @endforeach
                ];
                document.addEventListener("DOMContentLoaded", () => {
                    new Chart(document.getElementById('terlaris'), {
                        type: 'bar',
                        data: {
                            labels: label,
                            datasets: [{
                                label: 'Produk terlaris',
                                data: jumlah,
                                backgroundColor: 'rgb(255, 0, 0)',
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