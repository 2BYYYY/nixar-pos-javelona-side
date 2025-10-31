/*
    Author: John Roland L. Octavio, Josh Dane M. Labistre, Ignatius Warren Benjamin D. Javelona

    `views.sql` is intended to simplify PHP queries by creating database VIEWS 
    that perform multiple table JOINs when retrieving data in different tables.
*/

USE nixar_autoglass_db;

-- ================================== INVENTORY ==================
CREATE OR REPLACE VIEW product_inventory_view AS
SELECT np.product_name,
       np.nixar_product_sku,
       np.product_img_url,
       pm.category,
       pm.material_name,
       pm.product_material_id,
       i.min_threshold,
       i.current_stock,
	   ps.base_price,
       s.supplier_id,
       s.supplier_name,
       np.mark_up,
       ROUND(ps.base_price + (ps.base_price * (np.mark_up / 100)), 2) AS final_price
FROM nixar_products np
JOIN product_materials pm ON np.product_material_id = pm.product_material_id
JOIN inventory i ON np.nixar_product_sku = i.nixar_product_sku
JOIN product_suppliers ps ON np.product_supplier_id = ps.product_supplier_id
JOIN suppliers s ON ps.supplier_id = s.supplier_id
WHERE np.is_deleted = 0;

-- ============== INVENTORY REPORT LIST METRICS ==============

CREATE OR REPLACE VIEW low_stock_items_view AS  
SELECT  
    np.nixar_product_sku, 
    np.product_name, 
    i.current_stock, 
    i.updated_at 
FROM inventory i  
JOIN nixar_products np ON i.nixar_product_sku = np.nixar_product_sku 
JOIN product_materials pm ON np.product_material_id = pm.product_material_id 
WHERE i.current_stock <= i.min_threshold 
ORDER BY i.current_stock ASC;

CREATE OR REPLACE VIEW most_sold_item_by_qty_view AS 
SELECT  
    np.product_name, 
    SUM(rd.quantity) AS total_quantity_sold 
FROM receipt_details rd 
JOIN nixar_products np ON rd.nixar_product_sku = np.nixar_product_sku 
JOIN product_materials pm ON np.product_material_id = pm.product_material_id 
GROUP BY np.nixar_product_sku, np.product_name, pm.category 
ORDER BY total_quantity_sold DESC 
LIMIT 5; 

CREATE OR REPLACE VIEW best_selling_item_by_revenue_view AS 
SELECT  
    np.product_name, 
    ROUND(SUM(rd.quantity * np.mark_up), 2) AS total_revenue  
FROM receipt_details rd  
JOIN nixar_products np ON rd.nixar_product_sku = np.nixar_product_sku 
JOIN product_materials pm ON np.product_material_id = pm.product_material_id 
GROUP BY np.nixar_product_sku, np.product_name 
ORDER BY total_revenue DESC 
LIMIT 5; 

-- ============== SALES REPORT METRICS ==================
CREATE OR REPLACE VIEW sales_report_view AS 
SELECT 
	SUM(total_amount) AS total_revenue, 
	COUNT(receipt_id) AS total_transactions,
	AVG(total_amount) AS avg_transaction_value,
    0 AS profit_performance
FROM receipts AS r;

-- ============== SALES REPORT LIST METRICS ==============

CREATE OR REPLACE VIEW category_performance_view AS 
SELECT 
    category, 
    COUNT(category) AS category_performance
FROM product_materials
GROUP BY category
ORDER BY category_performance DESC
LIMIT 5;

CREATE OR REPLACE VIEW sales_by_time_view AS 
SELECT
	DATE_FORMAT(created_at, '%l %p') AS hour_label,  
	COUNT(*) AS total_orders
FROM receipts
GROUP BY hour_label, HOUR(created_at)
ORDER BY HOUR(created_at)
LIMIT 5;
