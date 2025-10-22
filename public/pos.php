<?php
    include_once __DIR__ . '/../includes/config/_init.php';  

    $PageTitle = "Transaction | NIXAR POS";
    $CssPath = "assets/css/styles.css";
    $JSPath = "assets/js/scripts.js";

    include_once '../includes/head.php';

    SessionManager::checkSession();

    $dummyProducts = [
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
            [
                    'name' => 'Glass Cleaner',
                    'price' => 120,
                    'pic' => 'assets/img/sample.png',
                    'category' => 'Car Care'
            ],
    ];
?>
    <div class="container-fluid p-0 m-0 py-3 px-4 d-flex flex-column align-items-center gap-2" style="height: 100vh; overflow: hidden;">
        <?php include_once '../includes/components/nav.php'; ?>
        <div class="w-100 flex-grow-1 d-sm-none d-flex justify-content-center align-items-center">
            <p class="text-center">Transaction Functionalities are only available on larger devices.</p>
        </div>
        <div class="w-100 d-none d-sm-flex flex-grow-1 row g-2" style="overflow:hidden;">
            <div class="col-8" style="height: 98%">
                <div class="w-100 h-100 d-flex flex-column gap-2">
                    <div class="w-100 d-flex flex-shrink-0 justify-content-between align-items-center">
                        <h2>Product List</h2>
                      <div class="input-wrapper">
                        <input
                          type="text"
                          placeholder="Search"
                          class="text-input"
                        />
                      </div>
                    </div>
                    <div class="w-full d-flex flex-shrink-0 justify-content-between align-items-center gap-2 z-1 bg-white pb-2">
                        <div class="filter-tile">
                            <h6>All Items</h6>
                            <p class="text-muted">0 Items</p>
                        </div>
                        <div class="filter-tile">
                            <h6>Glass</h6>
                            <p class="text-muted">0 Items</p>
                        </div>
                        <div class="filter-tile">
                            <h6>Tints</h6>
                            <p class="text-muted">0 Items</p>
                        </div>
                        <div class="filter-tile">
                            <h6>Rubber</h6>
                            <p class="text-muted">0 Items</p>
                        </div>
                    </div>
                    <div class="w-full overflow-y-auto row g-3" style="min-height: 0;">
                        <?php foreach ($dummyProducts as $dummyProduct): ?>
                            <?php include '../includes/components/transaction-product-card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-4" style="height: 98%">
                <div class="w-100 h-100 d-flex flex-column justify-content-start gap-2 rounded-3 border p-3">
                    <h2>Order Detail</h2>
                    <p>0 items selected</p>
                    <div class="flex-grow-1 border shadow-sm rounded-2">

                    </div>
                    <a href="/nixar-pos/public/checkout.php" class="btn d-inline-flex align-items-center justify-content-center gap-2">
                        Proceed to Payment
                        <i class="fa-solid fa-chevron-right text-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php include_once '../includes/footer.php'; ?>
