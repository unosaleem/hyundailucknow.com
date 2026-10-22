<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST requests are allowed.']);
    exit;
}

$model = trim((string) ($_POST['model'] ?? ''));
$name = trim((string) ($_POST['name'] ?? ''));
$city = trim((string) ($_POST['city'] ?? ''));
$mobile = preg_replace('/\D+/', '', (string) ($_POST['mobile'] ?? ''));
$enquiryType = trim((string) ($_POST['enquiry_type'] ?? 'Best Offer'));
$honeypot = trim((string) ($_POST['website'] ?? ''));
$formStartedAt = filter_var($_POST['form_started_at'] ?? null, FILTER_VALIDATE_INT);

if ($honeypot !== '' || $formStartedAt === false || $formStartedAt < (time() * 1000 - 86400000) || $formStartedAt > (time() * 1000 - 1500)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Unable to process this request.']);
    exit;
}

$allowedModels = [
    'Creta', 'Venue', 'Venue N Line', 'Exter', 'Verna', 'i20',
    'i20 N Line', 'Alcazar', 'Grand i10 Nios', 'Aura', 'Creta Electric', 'IONIQ 5',
];
$allowedEnquiries = ['Best Offer', 'Test Drive Enquiry'];

if (!in_array($model, $allowedModels, true)
    || mb_strlen($name) < 2
    || mb_strlen($name) > 120
    || mb_strlen($city) < 2
    || mb_strlen($city) > 100
    || !preg_match('/^[6-9][0-9]{9}$/', $mobile)
    || !in_array($enquiryType, $allowedEnquiries, true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please enter valid lead details.']);
    exit;
}

try {
    require __DIR__ . '/db.php';
    $statement = $pdo->prepare(
        'INSERT INTO leads (model, full_name, city, mobile, enquiry_type) VALUES (:model, :full_name, :city, :mobile, :enquiry_type)'
    );
    $statement->execute([
        ':model' => $model,
        ':full_name' => $name,
        ':city' => $city,
        ':mobile' => $mobile,
        ':enquiry_type' => $enquiryType,
    ]);

    echo json_encode(['success' => true, 'message' => 'Your enquiry has been received.']);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to save your enquiry right now. Please try again.']);
}
