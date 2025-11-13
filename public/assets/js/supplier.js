/*
 * Author: John Roland Octavio
 * supplier.js contains ALL data fetching logic and DOM Manipulation for dynamic rendering for supplier page.
*/
const supplierTbl = document.getElementById('container-supplier-data');
const pagination = document.getElementById('pagination-container');


const LIMIT = 10;
let currentPage = 1;
const fetchSuppliers = async (page = 1) => {
    try {
        const response = await fetch(`handlers/fetch_suppliers.php?limit=${ LIMIT }&page=${ page }`)
        const data = await response.json();
        
        if(data.suppliers.length === 0) {
            supplierTbl.innerHTML = `
                <tr><td colspan="7" style="text-align:center;">No suppliers found in the database.</td></tr>
            `;
            return;
        }

        currentPage = data.currentPage;
        console.log(data);
        renderRows(data.suppliers);
        updatePagination(data.totalPages, data.currentPage)
    } catch (err) {
        console.error(err.message);
    }
}

const createSupplierRow = (supplier) => {
    return `
        <tr>
            <td>${supplier.supplier_name}</td>
            <td>${supplier.contact_no}</td>
            <td>${supplier.product_supply_count}</td>
            <td>
                <button
                  type="button"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierProductsModal"
                  onclick="fetchSupplierProducts(${supplier.supplier_id})"
                  class="btn"
                >
                    <i class="fa-solid fa-eye"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-edit"
                  data-supplier="${JSON.stringify(supplier)}"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>
            
            </td>
        </tr>
    `;
}

const renderRows = (suppliers) => {
    supplierTbl.innerHTML = suppliers.map(supplier => createSupplierRow(supplier)).join('\n');
};

const fetchSupplierProducts = async (supplierId) => {
    try {
        const response = await fetch(`handlers/fetch_supplier_products.php?supplier_id=${supplierId}`);
        const data = await response.json();

        console.log('Products for supplier:', supplierId, data);
        populateSupplierProductForms(data.supplier_products);
    } catch (error) {
        console.error(error.message);
    }
}

const createProductRows = (product) => {
    console.log(product);
    return `
        <tr data-product-supplier-id="${product.product_supplier_id}">
            <td>${product.nixar_product_sku}</td>
            <td>${product.product_name}</td>
            <td>
                <input type="number" min="0" max="999999" value="${product.base_price}" disabled/>
            </td>
            <td>
                <button
                  type="button"
                  onclick="toggleEditButton(this)"
                  class="btn"
                >
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button
                  type="button"
                  class="btn"
                  data-product-supplier-id="${product.product_supplier_id}"
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
}

const toggleEditButton = (button) => {
    const row = button.closest('tr');
    const input = row.querySelector('input');
    const isEditing = input.disabled; // editing only if input is enabled

    if (isEditing) {
        input.disabled = false;
        input.focus();
    } else {
        const updatedPrice = parseFloat(input.value);
        input.value = updatedPrice;
        input.disabled = true;
        
        // Update database
        const productSupplierId = row.dataset.productSupplierId;
        updateBasePrice(productSupplierId, updatedPrice);
    }
    button.innerHTML = (isEditing) ? `<i class="fa-solid fa-check"></i>` : `<i class="fa-solid fa-pen-to-square"></i>`;
}

const updateBasePrice = async (id, updatedPrice) => {
    try {
        const response = await fetch('handlers/update_price.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({ 'product_supplier_id': id, 'base_price': updatedPrice })
        });
        const data = await response.json();
        if (!data.success) {
            console.error(error.message);
            return;
        }
        const supplierModal = bootstrap.Modal.getInstance(document.getElementById('supplierProductsModal'));
        if (supplierModal) supplierModal.hide();
        fetchSuppliers();
    } catch (error) {
        console.error(error.message);
    }
}

const populateSupplierProductForms = (supplierProducts) => {
    const supplierProductsContainer = document.getElementById('container-supplier-products');
    supplierProductsContainer.innerHTML = supplierProducts.map(product => createProductRows(product)).join('\n');
}

const updatePagination = (totalPages, currentPage) => {
    let htmlString = '';
    // Render Previous button if current page is not the first page
    if (currentPage > 1) {
        htmlString += `
        <li class="page-item me-2">
            <a class="page-link" href="#" data-page="${ currentPage - 1 }">
            ← Previous
            </a>
        </li>`;
    }
    
    const MAX_ICONS_VISIBLE = 3;
    let start = Math.max(1, currentPage - 1);
    let end = Math.min(totalPages, start + MAX_ICONS_VISIBLE - 1);
    // Adjust starting value if it is nearing the end page
    if (end - start < MAX_ICONS_VISIBLE - 1) {
        start = Math.max(1, end - MAX_ICONS_VISIBLE + 1);
    }
    // Render all page icons
    for (let i = start; i <= end; i++) {
        htmlString += `
            <li class="page-item ${ i === currentPage ? 'active' : '' }">
                <a class="page-link" href="#" data-page="${ i }">${ i }</a>
            </li>
        `;
    }
    // Render Next button if current page is not the last page
    if (currentPage < totalPages) {
      htmlString += `
        <li class="page-item ms-2">
            <a class="page-link" href="#" data-page="${ currentPage + 1 }">
                Next →
            </a>
        </li>`;
    }
    // Embed pagination buttons into pagination controller
    pagination.innerHTML = htmlString;
    const pageLinks = pagination.querySelectorAll('.page-link');

    pageLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            if(isNaN(page)) {
                return;
            }
            fetchSuppliers(page)
        })
    })
}

document.addEventListener('DOMContentLoaded', () => {
    fetchSuppliers();
})