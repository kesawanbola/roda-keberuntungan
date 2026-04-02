<?php
// Koneksi database (sesuaikan dengan hosting kamu)
$conn = new mysqli("localhost", "root", "", "lucky_spin");

// Logika untuk update status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] == 'approve') ? 'Sukses' : 'Ditolak';
    $conn->query("UPDATE users_spin SET status='$status' WHERE id=$id");
}

$result = $conn->query("SELECT * FROM users_spin ORDER BY waktu_spin DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Lucky Spin</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #16213e; color: white; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; }
        .btn-approve { background: #27ae60; }
        .btn-reject { background: #e74c3c; }
        .status-Sukses { color: #27ae60; font-weight: bold; }
        .status-Pending { color: #f39c12; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Daftar Klaim Hadiah</h2>
    <table>
        <tr>
            <th>ID User</th>
            <th>Hadiah</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['hadiah'] ?></td>
            <td><?= $row['waktu_spin'] ?></td>
            <td class="status-<?= $row['status'] ?>"><?= $row['status'] ?></td>
            <td>
                <?php if($row['status'] == 'Pending'): ?>
                    <a href="?action=approve&id=<?= $row['id'] ?>" class="btn btn-approve">Setujui</a>
                    <a href="?action=reject&id=<?= $row['id'] ?>" class="btn btn-reject">Tolak</a>
                <?php else: ?>
                    Selesai
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
