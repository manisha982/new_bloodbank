<?php
require_once '../includes/../db.php'; // Adjust if needed

// Handle deletion via index.php?page=contact_us&delete=ID
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_messages WHERE id = $delete_id");
    header("Location: index.php?page=contact_us&deleted=1");
    exit;
}

// Fetch all messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="card shadow-sm mt-5">
    <div class="card-header bg-danger text-white fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-envelope-fill"></i> Recent Contact Messages</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($messages->num_rows > 0): ?>
                        <?php while ($msg = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?= $msg['id'] ?></td>
                                <td><?= htmlspecialchars($msg['full_name']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= htmlspecialchars($msg['phone_number']) ?: '-' ?></td>
                                <td><?= htmlspecialchars($msg['subject']) ?: '(No Subject)' ?></td>
                                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                                <td><?= date("d M Y, h:i A", strtotime($msg['created_at'])) ?></td>
                                <td>
                                    <a href="index.php?page=contact_us&delete=<?= $msg['id'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this message?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-3 text-muted">No contact messages found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>