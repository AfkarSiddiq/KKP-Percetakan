<div class="col-lg-12">
    <div class="card mb-12">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Bahan Paling banyak habis 1 bulan terakhir
        </div>

        <!-- Bar Chart -->
        <div class="card-body">
            <canvas id="Stokbarang" width="100%" height="50"></canvas>

            <script>
                // Fungsi untuk menghasilkan warna acak
                function randomColor() {
                    // Generate random hue (between 0 and 360)
                    var hue = Math.floor(Math.random() * 360);

                    // Set saturation and brightness to create a pastel color
                    var saturation = 50 + Math.floor(Math.random() * 25); // Adjust saturation as needed
                    var brightness = 70 + Math.floor(Math.random() * 10); // Adjust brightness as needed

                    // Convert HSL to RGB
                    var hslToRgb = function(h, s, l) {
                        var r, g, b;
                        h /= 360;
                        s /= 100;
                        l /= 100;

                        if (s === 0) {
                            r = g = b = l;
                        } else {
                            var hue2rgb = function(p, q, t) {
                                if (t < 0) t += 1;
                                if (t > 1) t -= 1;
                                if (t < 1 / 6) return p + (q - p) * 6 * t;
                                if (t < 1 / 2) return q;
                                if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
                                return p;
                            };

                            var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                            var p = 2 * l - q;
                            r = hue2rgb(p, q, h + 1 / 3);
                            g = hue2rgb(p, q, h);
                            b = hue2rgb(p, q, h - 1 / 3);
                        }

                        return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
                    };

                    var rgbColor = hslToRgb(hue, saturation, brightness);

                    // Convert RGB to hex format
                    var hexColor = '#' + rgbColor.map(function(value) {
                        return ('0' + value.toString(16)).slice(-2); // Ensure 2-digit hex values
                    }).join('');

                    return hexColor;
                }
                // ambil data nama nama dan stok dari DashboardController di fungsi index
                var lbl = [
                    @foreach ($ar_stok as $s)
                        '{{ $s->nama_bahan }}',
                    @endforeach
                    @foreach ($ar_stok_not_meter as $s)
                        @if ($s->jumlah % 5 == 0)
                            '{{ $s->nama_bahan }}',
                        @else
                            @break
                        @endif
                    @endforeach
                ];
                var stk = [
                    @foreach ($ar_stok as $s)
                        '{{ $s->jumlah }}',
                    @endforeach
                    @foreach ($ar_stok_not_meter as $s)
                        @if ($s->jumlah % 5 == 0)
                            '{{ $s->jumlah * 0.2 }}',
                        @else
                            @break
                        @endif
                    @endforeach
                ];
                document.addEventListener("DOMContentLoaded", () => {
                    var colors = [];

                    // Generate warna acak sesuai dengan jumlah data
                    for (var i = 0; i < jml.length; i++) {
                        colors.push(randomColor());
                    }
                    new Chart(document.getElementById('Stokbarang'), {
                        type: 'pie',
                        data: {
                            labels: lbl,
                            datasets: [{
                                label: 'Bahan paling banyak habis dalam bulan ini',
                                data: stk,
                                backgroundColor: colors,
                                hoverOffset: 4
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
