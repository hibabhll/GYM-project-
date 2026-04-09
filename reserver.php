<?php
// reserver.php — Enregistre une réservation de coach
session_start();
include 'db.php';

header('Content-Type: application/json');

// Vérifier session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Non connecté. Merci de te connecter.']);
    exit();
}

// Récupérer les données POST
$coach_id   = intval($_POST['coach_id']   ?? 0);
$coach_name = htmlspecialchars(trim($_POST['coach_name'] ?? ''));
$date       = htmlspecialchars(trim($_POST['date']       ?? ''));
$time       = htmlspecialchars(trim($_POST['time']       ?? ''));
$user_id    = intval($_SESSION['user_id']);

// Validation
if (!$coach_id || !$date || !$time) {
    echo json_encode(['success' => false, 'error' => 'Données manquantes.']);
    exit();
}

// Vérifier que la date n'est pas dans le passé
if ($date < date('Y-m-d')) {
    echo json_encode(['success' => false, 'error' => 'La date est déjà passée.']);
    exit();
}

// Vérifier double réservation (même coach, même date, même heure)
$check = $conn->prepare("
    SELECT id FROM reservations
    WHERE coach_id = ? AND date = ? AND time = ? AND status != 'cancelled'
");
$check->bind_param("iss", $coach_id, $date, $time);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Ce créneau est déjà réservé. Choisis un autre horaire.']);
    $check->close();
    exit();
}
$check->close();

// Insérer la réservation
$stmt = $conn->prepare("
    INSERT INTO reservations (user_id, coach_id, coach_name, date, time, status, created_at)
    VALUES (?, ?, ?, ?, ?, 'confirmed', NOW())
");
$stmt->bind_param("iisss", $user_id, $coach_id, $coach_name, $date, $time);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => "Réservation confirmée avec {$coach_name} le {$date} à {$time} !"
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Erreur lors de la réservation. Réessaie.']);
}

$stmt->close();
$conn->close();
?>