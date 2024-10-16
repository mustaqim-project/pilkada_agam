<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section-header {
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .col {
            flex: 1 1 calc(25% - 20px);
            box-sizing: border-box;
        }
        .card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 20px;
            text-align: center;
        }
        .card-icon {
            padding: 20px;
            font-size: 2rem;
            color: white;
            background-color: #4e73df;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .card-header h4 {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }
        .card-body {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<section class="section">
    <div class="section-header">
        <h1>Dashboard Utama</h1>
    </div>
    <div class="row">
        <!-- Looping Start -->

        <div class="col">
            <div class="card">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-header">
                    <h4>Tim</h4>
                </div>
                <div class="card-body">
                    50 <!-- Jumlah Tim -->
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-icon bg-primary">
                    <i class="fas fa-money-bill"></i>
                </div>
                <div class="card-header">
                    <h4>Anggaran</h4>
                </div>
                <div class="card-body">
                    100 <!-- Jumlah Anggaran -->
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-icon bg-primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="card-header">
                    <h4>Periode</h4>
                </div>
                <div class="card-body">
                    30 <!-- Jumlah Periode -->
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-header">
                    <h4>Laporan Kegiatan</h4>
                </div>
                <div class="card-body">
                    75 <!-- Jumlah Laporan Kegiatan -->
                </div>
            </div>
        </div>

        <!-- Looping End -->
    </div>
</section>

</body>
</html>
