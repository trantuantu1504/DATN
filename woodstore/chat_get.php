<?php
// Lấy tất cả tin nhắn giữa user hiện tại và admin (id = 1)
$matk = $_SESSION['matk'];

$stmt = $conn->prepare("
    SELECT * FROM messages 
    WHERE (sender_id = ? AND receiver_id = 1) 
       OR (sender_id = 1 AND receiver_id = ?)
    ORDER BY created_at ASC
");
$stmt->bind_param("ii", $matk, $matk);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $who = ($row['sender_id'] == $matk) ? "Bạn" : "Admin";
    echo "<p><strong>{$who}:</strong> " . htmlspecialchars($row['message']) . "</p>";
}
?>