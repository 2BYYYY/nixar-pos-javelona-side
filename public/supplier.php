<?php 
include_once __DIR__ . '/../includes/config/_init.php'; 
  $Role = ucwords(strtolower(SessionManager::get('role')));
  $PageTitle = "{$Role} - Suppliers | NIXAR POS";
  $CssPath = "assets/css/styles.css";
  $JSPath = "assets/js/scripts.js";  

  include_once '../includes/head.php';
  SessionManager::checkSession()
?>

 <div class="container-fluid p-0 m-0 h-100 px-4 py-3  d-flex flex-column overflow-x-hidden">
    <?php include_once '../includes/components/nav.php'; ?>
    <div class="row container-fluid p-0 m-0 mt-3 flex-fill mb-3 gap-3">
    <h2 class="p-0">Supplier Information</h2>

    </div>
 </div>