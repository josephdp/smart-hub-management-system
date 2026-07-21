<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Smart-Hub</title>
</head>
<body>
    <h2>Halo, Admin Smart-Hub!</h2>
    <p>Terdapat pembaruan status peminjaman inventaris.</p>
    <p><strong>Status saat ini:</strong> {{ $borrowing->status }}</p>
    <p><strong>Waktu Update:</strong> {{ $borrowing->updated_at }}</p>
    <br>
    <p>Terima kasih,</p>
    <p>Sistem Smart-Hub</p>
</body>
</html>