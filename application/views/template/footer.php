    <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; PT Maju Jaya Elektronik <?= date('Y'); ?></span>
            </div>
        </div>
    </footer> -->
    
    </div> </div> <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        /** * Inisialisasi Global untuk tabel standar.
         * Note: #auditLogTable dihapus dari sini karena diinisialisasi 
         * secara khusus di filenya sendiri (index.php) untuk fitur penomoran.
         */
        $('#orderTable, #dataTable, #reportTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
            "order": [[ 1, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "infoEmpty": "Data kosong",
                "paginate": {
                    "next": "Lanjut",
                    "previous": "Kembali"
                }
            }
        });

        /** * 2. INISIALISASI CHART.JS OTOMATIS
         */
        const canvas = document.getElementById('orderChart');
        // Hanya jalankan jika canvas ada dan variabel data global tersedia
        if (canvas && typeof Chart !== 'undefined' && typeof chartDataGlobal !== 'undefined') {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartDataGlobal.labels,
                    datasets: [{
                        label: 'Jumlah Order',
                        data: chartDataGlobal.totals,
                        backgroundColor: ['#858796', '#36b9cc', '#1cc88a', '#e74a3b'],
                        borderColor: ['#858796', '#36b9cc', '#1cc88a', '#e74a3b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    });
</script>

</body>
</html>