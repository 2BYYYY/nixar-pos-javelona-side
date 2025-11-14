<?php 
    header("Content-Type: application/json");

    include_once __DIR__ . '/../../includes/config/_init.php';  
    SessionManager::checkSession();

    // Default to (2000-01-01 00:00:00) as start and the current date as end if no input is provided
    $Start = isset($_GET['start']) ? InputValidator::sanitizeData($_GET['start']) : '2000-01-01 00:00:00';
    $End = isset($_GET['end']) ? InputValidator::sanitizeData($_GET['end']) : date("Y-m-d H:i:s");

    // Append end time when date format is YYYY-MM-DD
    if ($End && strlen($End) === 10) {
        $End .= " 23:59:59";
    }

    $Conn = DatabaseConnection::getInstance()->getConnection();
    try {
        $Transaction = new Transaction($Conn);
        $Inventory = new Inventory($Conn);

        // Fetch transactions within date
        $AllTransactions = $Transaction->fetchTransactionByRange($Start, $End);
        if (!$AllTransactions['result']) {
            $AllTransactions = ['success' => false, 'transactions' => []]; 
        }
        // Fetch Inventory record
        $ProductInventory = $Inventory->fetchInventory();
        // Fetch aggregated metrics
        $AllSales = $Inventory->salesReportMetrics();
        $BestItemCategory = $Inventory->inventoryMetricsBestSellingItem();
        $LowStock = $Inventory->inventoryMetricsStock();
        $MostSold = $Inventory->inventoryMetricsSold();
        $SalesTime = $Inventory->salesListMetricsByTime();
        $SalesCategory = $Inventory->salesListMetricsByCategory();
        $ListMetric = $Inventory->inventoryListMetricsMostSold();
        $BestSelling = $Inventory->inventoryListMetricsBestSelling();
        $ListLowStock = $Inventory->inventoryListMetricsStock();
    } catch (Exception $E) {
        echo json_encode([
            'success' => false,
            'message' => $E->getMessage()
        ]);
    }
?>