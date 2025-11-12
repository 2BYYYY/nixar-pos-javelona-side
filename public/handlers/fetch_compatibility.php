<!-- AUTHORS: Raean Chrissean R. Tamayo, -->
<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../../includes/config/_init.php';
SessionManager::checkSession();

$Conn = DatabaseConnection::getInstance()->getConnection();

if (!isset($_GET['sku']) || empty(trim($_GET['sku']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No SKU provided.']);
    exit;
}

$sku = trim($_GET['sku']);
$Product = new NixarProduct($Conn);
$fetchResult = $Product->fetchCompatible($sku);

if ($fetchResult === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error fetching data.']);
    exit;
}

http_response_code(200);
echo json_encode(['success' => true, 'data' => $fetchResult]);
?>
