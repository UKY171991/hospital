@extends('layouts.admin')

@section('title', 'Manage Items')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="my-4">Item List</h2>
        <div>
            <a href="#" class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#addSaleModal">+ Add Sale</a> 
            <a href="#" class="btn btn-warning me-1" data-bs-toggle="modal" data-bs-target="#addPurchaseModal">+ Add Purchase</a>
            <a href="#" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#addItemModal">+ Add Item</a>
<!-- Add Purchase Modal -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="addPurchaseModalLabel">Add Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseForm">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No</label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" readonly value="AUTO">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="purchase_date">Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="purchase_order_no">Purchase Order No</label>
                                <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="eway_bill_no">Eway Bill No</label>
                                <input type="text" class="form-control" id="eway_bill_no" name="eway_bill_no">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6>Items</h6>
                    <table class="table table-bordered" id="purchase_items_table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-row-index="0">
                                <td>
                                    <input type="hidden" name="purchase_items[0][item_id]" class="item-id">
                                    <input type="text" readonly class="form-control item-name" placeholder="Select Item">
                                    <button type="button" class="btn btn-sm btn-secondary browse-purchase-items-btn mt-1">Browse</button>
                                </td>
                                <td><input type="number" class="form-control item-price" name="purchase_items[0][price]" required></td>
                                <td><input type="number" class="form-control item-quantity" name="purchase_items[0][quantity]" min="1" value="1" required></td>
                                <td><input type="number" class="form-control item-amount" name="purchase_items[0][amount]" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-purchase-item-row">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-sm" id="add_purchase_item_row">Add Item</button>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="form-group row">
                                <label for="purchase_total_amount" class="col-sm-4 col-form-label">Total Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" readonly class="form-control" id="purchase_total_amount" name="total_amount" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="purchase_total_discount" class="col-sm-4 col-form-label">Total Discount</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="purchase_total_discount" name="total_discount" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="purchase_grand_total" class="col-sm-4 col-form-label">Grand Total</label>
                                <div class="col-sm-8">
                                    <input type="number" readonly class="form-control" id="purchase_grand_total" name="grand_total" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="purchase_remark">Remark</label>
                        <textarea class="form-control" id="purchase_remark" name="remark" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="save_purchase_btn">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Purchase Modal -->
<div class="modal fade" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editPurchaseModalLabel">Edit Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPurchaseForm">
                    <!-- Similar fields as Add Purchase Modal -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Purchase Modal -->
<div class="modal fade" id="deletePurchaseModal" tabindex="-1" aria-labelledby="deletePurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deletePurchaseModalLabel">Delete Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this purchase?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePurchase">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Browse Items Modal for Purchase -->
<div class="modal fade" id="browsePurchaseItemsModal" tabindex="-1" aria-labelledby="browsePurchaseItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="browsePurchaseItemsModalLabel">Select Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="purchase_item_search" class="form-control mb-2" placeholder="Search items...">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="browse_purchase_items_list">
                            <!-- Items will be loaded here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addItemForm">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="item_code" class="form-label">Item Code</label>
                        <input type="text" class="form-control" id="item_code" name="item_code">
                    </div>
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Purchase Price</label>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="sales_price" class="form-label">Sales Price</label>
                        <input type="number" class="form-control" id="sales_price" name="sales_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="opening_stock" class="form-label">Opening Stock</label>
                        <input type="number" class="form-control" id="opening_stock" name="opening_stock" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Toastr CSS/JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Add CSRF token to all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // --- PURCHASE MODAL LOGIC ---
    let allItems = [];
    let currentPurchaseItemRowIndex = 0;
    function loadPurchaseItems() {
        $.ajax({
            url: "{{ route('items.index') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                allItems = response.items || [];
                renderPurchaseItemsList();
            },
            error: function(xhr) {
                toastr.error("Error loading items");
            }
        });
    }
    loadPurchaseItems();
    function renderPurchaseItemsList(searchTerm = '') {
        const itemsList = $('#browse_purchase_items_list');
        itemsList.empty();
        if (!allItems || allItems.length === 0) {
            itemsList.html('<tr><td colspan="4" class="text-center">No items available</td></tr>');
            return;
        }
        const filteredItems = searchTerm ? 
            allItems.filter(item => 
                item.item_name.toLowerCase().includes(searchTerm.toLowerCase()) || 
                item.item_code.toLowerCase().includes(searchTerm.toLowerCase())
            ) : allItems;
        if (filteredItems.length === 0) {
            itemsList.html('<tr><td colspan="4" class="text-center">No items match your search</td></tr>');
            return;
        }
        filteredItems.forEach(item => {
            itemsList.append(`
                <tr>
                    <td>${item.item_name}</td>
                    <td>${item.item_code}</td>
                    <td>${item.unit || ''}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm select-browse-purchase-item" 
                            data-item-id="${item.id}" 
                            data-item-name="${item.item_name}" 
                            data-item-code="${item.item_code}" 
                            data-item-unit="${item.unit}">
                            Select
                        </button>
                    </td>
                </tr>
            `);
        });
    }
    $('#purchase_item_search').on('keyup', function() {
        renderPurchaseItemsList($(this).val());
    });
    $(document).on('click', '.browse-purchase-items-btn', function() {
        currentPurchaseItemRowIndex = $(this).closest('tr').data('row-index');
        $('#browsePurchaseItemsModal').modal('show');
    });
    $(document).on('click', '.select-browse-purchase-item', function() {
        const itemId = $(this).data('item-id');
        const itemName = $(this).data('item-name');
        const itemCode = $(this).data('item-code');
        const row = $(`#purchase_items_table tbody tr[data-row-index="${currentPurchaseItemRowIndex}"]`);
        row.find('.item-id').val(itemId);
        row.find('.item-name').val(`${itemName} (${itemCode})`);
        $('#browsePurchaseItemsModal').modal('hide');
    });
    $('#add_purchase_item_row').on('click', function() {
        const rowCount = $('#purchase_items_table tbody tr').length;
        const newRowIndex = rowCount;
        const newRow = `
            <tr data-row-index="${newRowIndex}">
                <td>
                    <input type="hidden" name="purchase_items[${newRowIndex}][item_id]" class="item-id">
                    <input type="text" readonly class="form-control item-name" placeholder="Select Item">
                    <button type="button" class="btn btn-sm btn-secondary browse-purchase-items-btn mt-1">Browse</button>
                </td>
                <td><input type="number" class="form-control item-price" name="purchase_items[${newRowIndex}][price]" required></td>
                <td><input type="number" class="form-control item-quantity" name="purchase_items[${newRowIndex}][quantity]" min="1" value="1" required></td>
                <td><input type="number" class="form-control item-amount" name="purchase_items[${newRowIndex}][amount]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-purchase-item-row">Remove</button></td>
            </tr>
        `;
        $('#purchase_items_table tbody').append(newRow);
    });
    $(document).on('click', '.remove-purchase-item-row', function() {
        if ($('#purchase_items_table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            recalculatePurchaseTotal();
        } else {
            toastr.warning('At least one item is required.');
        }
    });
    $(document).on('input', '.item-quantity, .item-price', function() {
        calculatePurchaseRowAmount($(this).closest('tr'));
    });
    function calculatePurchaseRowAmount(row) {
        const price = parseFloat(row.find('.item-price').val()) || 0;
        const quantity = parseInt(row.find('.item-quantity').val()) || 0;
        const amount = price * quantity;
        row.find('.item-amount').val(amount.toFixed(2));
        recalculatePurchaseTotal();
    }
    function recalculatePurchaseTotal() {
        let totalAmount = 0;
        $('#purchase_items_table tbody tr').each(function() {
            totalAmount += parseFloat($(this).find('.item-amount').val()) || 0;
        });
        $('#purchase_total_amount').val(totalAmount.toFixed(2));
        const discount = parseFloat($('#purchase_total_discount').val()) || 0;
        const grandTotal = totalAmount - discount;
        $('#purchase_grand_total').val(grandTotal.toFixed(2));
    }
    $('#purchase_total_discount').on('input', function() {
        recalculatePurchaseTotal();
    });
    // AJAX submit for add purchase
    $('#save_purchase_btn').on('click', function() {
        let isValid = true;

        // Validate supplier name
        if (!$('#supplier_name').val().trim()) {
            toastr.error('Please enter supplier name');
            isValid = false;
        }

        // Validate items
        const items = [];
        $('#purchase_items_table tbody tr').each(function() {
            const itemId = $(this).find('.item-id').val();
            const price = parseFloat($(this).find('.item-price').val());
            const quantity = parseInt($(this).find('.item-quantity').val());
            const amount = parseFloat($(this).find('.item-amount').val());

            if (!itemId || isNaN(price) || isNaN(quantity) || isNaN(amount)) {
                toastr.error('Please fill out all item details correctly.');
                isValid = false;
                return false;
            }

            items.push({
                item_id: itemId,
                price: price,
                quantity: quantity,
                amount: amount
            });
        });

        if (items.length === 0) {
            toastr.error('Please add at least one item.');
            isValid = false;
        }

        if (!isValid) return;

        // Prepare data for submission
        const data = {
            invoice_no: $('#invoice_no').val(),
            date: $('#purchase_date').val(),
            supplier_name: $('#supplier_name').val(),
            purchase_order_no: $('#purchase_order_no').val(),
            eway_bill_no: $('#eway_bill_no').val(),
            total_amount: parseFloat($('#purchase_total_amount').val()),
            remarks: $('#purchase_remark').val(),
            items: items
        };

        // Submit via AJAX
        $.ajax({
            url: '/purchase/store',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success(response.message);
                $('#addPurchaseModal').modal('hide');
                $('#purchaseForm')[0].reset();
                location.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.values(errors).forEach(error => toastr.error(error));
                } else {
                    toastr.error('Failed to add purchase.');
                }
            }
        });
    });

    // AJAX for Edit Purchase
    $('#editPurchaseForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '/purchases/' + $('#editPurchaseForm').data('id'),
            method: 'PUT',
            data: formData,
            success: function(response) {
                toastr.success(response.message);
                $('#editPurchaseModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message);
            }
        });
    });

    // AJAX for Delete Purchase
    $('#confirmDeletePurchase').on('click', function() {
        let purchaseId = $(this).data('id');
        $.ajax({
            url: '/purchases/' + purchaseId,
            method: 'DELETE',
            success: function(response) {
                toastr.success(response.message);
                $('#deletePurchaseModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message);
            }
        });
    });

    // AJAX for Add/Update Item
    $('#addItemForm').on('submit', function(e) {
        e.preventDefault();

        // Validate form fields
        const itemName = $('#item_name').val().trim();
        const purchasePrice = parseFloat($('#purchase_price').val());
        const salesPrice = parseFloat($('#sales_price').val());
        const unit = $('#unit').val().trim();
        const openingStock = parseInt($('#opening_stock').val());

        if (!itemName || !unit || isNaN(purchasePrice) || isNaN(salesPrice) || isNaN(openingStock)) {
            toastr.error('Please fill out all required fields correctly.');
            return;
        }

        // Prepare AJAX request
        const formData = $(this).serialize();
        const isEdit = $('#addItemModalLabel').text() === 'Edit Item';
        const url = isEdit ? '/items/' + $('#addItemForm').data('id') : '/items';
        const method = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                toastr.success(response.message);
                $('#addItemModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.values(errors).forEach(error => toastr.error(error));
                } else {
                    toastr.error('An error occurred while processing your request.');
                }
            }
        });
    });
});
</script>
<script>
$(document).on('click', '.edit-item-btn', function() {
    const item = $(this).data('item');

    // Populate the modal fields with the item's data
    $('#addItemModal #item_name').val(item.item_name);
    $('#addItemModal #item_code').val(item.item_code);
    $('#addItemModal #purchase_price').val(item.purchase_price);
    $('#addItemModal #sales_price').val(item.sales_price);
    $('#addItemModal #unit').val(item.unit);
    $('#addItemModal #opening_stock').val(item.opening_stock);

    // Set the data-id attribute for the form
    $('#addItemForm').data('id', item.id);

    // Change the modal title and button text
    $('#addItemModalLabel').text('Edit Item');
    $('#addItemForm button[type="submit"]').text('Update Item');

    // Open the modal
    $('#addItemModal').modal('show');
});
</script>
@endpush
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{-- Show 10 entries --}}
                    <select class="form-select form-select-sm d-inline-block" style="width: auto;">
                        <option selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </div>
                <div>
                    {{-- Export buttons --}}
                    <button class="btn btn-outline-secondary btn-sm">Excel</button>
                    <button class="btn btn-outline-secondary btn-sm">PDF</button>
                    <button class="btn btn-outline-secondary btn-sm">Print</button>
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Column visibility
                    </button>
                    <ul class="dropdown-menu">
                        {{-- Add column names here --}}
                        <li><a class="dropdown-item" href="#">Item Name</a></li>
                        <li><a class="dropdown-item" href="#">Item Code</a></li>
                        {{-- ... more columns --}}
                    </ul>
                </div>
                <div>
                    Search: <input type="search" class="form-control form-control-sm d-inline-block" style="width: auto;">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>Purchase Price</th>
                            <th>Sales Price</th>
                            <th>Unit</th>
                            <th>Opening Stock</th>
                            <th>Current Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_code ?? 'N/A' }}</td>
                                <td>{{ $item->purchase_price }}</td>
                                <td>{{ $item->sales_price }}</td>
                                <td>{{ $item->unit ?? 'N/A' }}</td>
                                <td>{{ $item->opening_stock }}</td>
                                <td>{{ $item->current_stock }}</td>
                                <td>
                                    {{-- Edit button --}}
                                    <a href="#" class="btn btn-sm btn-info me-1 edit-item-btn" data-item="{{ json_encode($item) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{-- Delete button (using a form for DELETE request) --}}
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                    {{-- Placeholder for toggle if needed --}}
                                    {{-- <button class="btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination links if using paginate() in controller --}}
            {{-- $items->links() --}}
        </div>
    </div>
</div>

<!-- Add Sale Modal -->
<div class="modal fade" id="addSaleModal" tabindex="-1" aria-labelledby="addSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addSaleModalLabel">Add/Update Sale</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="saleForm" action="{{ route('sale.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6>Items</h6>
                    <table class="table table-bordered" id="sale_items_table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-row-index="0">
                                <td>
                                    <input type="hidden" name="sale_items[0][item_id]" class="item-id">
                                    <input type="text" readonly class="form-control item-name" placeholder="Select Item">
                                    <button type="button" class="btn btn-sm btn-secondary browse-items-btn mt-1">Browse</button>
                                </td>
                                <td><input type="number" class="form-control item-price" name="sale_items[0][price_at_sale]" readonly></td>
                                <td><input type="number" class="form-control item-quantity" name="sale_items[0][quantity]" min="1" value="1"></td>
                                <td><input type="number" class="form-control item-amount" name="sale_items[0][amount]" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-item-row">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-sm" id="add_sale_item_row">Add Item</button>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-6 offset-md-6">
                            <div class="form-group row">
                                <label for="sale_total_amount" class="col-sm-4 col-form-label">Total Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" readonly class="form-control" id="sale_total_amount" name="total_amount" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sale_total_discount" class="col-sm-4 col-form-label">Discount</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="sale_total_discount" name="total_discount" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sale_grand_total" class="col-sm-4 col-form-label">Grand Total</label>
                                <div class="col-sm-8">
                                    <input type="number" readonly class="form-control" id="sale_grand_total" name="grand_total" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="sale_remark">Remark</label>
                        <textarea class="form-control" id="sale_remark" name="remark" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="save_sale_btn">Save Sale</button>
            </div>
        </div>
    </div>
</div>

<!-- Browse Items Modal -->
<div class="modal fade" id="browseItemsModal" tabindex="-1" aria-labelledby="browseItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="browseItemsModalLabel">Select Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="item_search" class="form-control mb-2" placeholder="Search items...">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Sales Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="browse_items_list">
                            <!-- Items will be loaded here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Add any page-specific JavaScript here --}}
@push('scripts')
<script>
$(document).ready(function() {
    // Load all items via AJAX
    let allItems = [];
    let currentItemRowIndex = 0;
    
    // Function to load all items
    function loadItems() {
        $.ajax({
            url: "{{ route('items.index') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                allItems = response.items || [];
                renderItemsList();
            },
            error: function(xhr) {
                console.error("Error loading items:", xhr);
            }
        });
    }
    
    // Call load items when page loads
    loadItems();
    
    function renderItemsList(searchTerm = '') {
        const itemsList = $('#browse_items_list');
        itemsList.empty();
        
        if (!allItems || allItems.length === 0) {
            itemsList.html('<tr><td colspan="5" class="text-center">No items available</td></tr>');
            return;
        }
        
        const filteredItems = searchTerm ? 
            allItems.filter(item => 
                item.item_name.toLowerCase().includes(searchTerm.toLowerCase()) || 
                item.item_code.toLowerCase().includes(searchTerm.toLowerCase())
            ) : allItems;
            
        if (filteredItems.length === 0) {
            itemsList.html('<tr><td colspan="5" class="text-center">No items match your search</td></tr>');
            return;
        }
        
        filteredItems.forEach(item => {
            itemsList.append(`
                <tr>
                    <td>${item.item_name}</td>
                    <td>${item.item_code}</td>
                    <td>${item.sales_price}</td>
                    <td>${item.current_stock || 0}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm select-browse-item" 
                            data-item-id="${item.id}" 
                            data-item-name="${item.item_name}" 
                            data-item-code="${item.item_code}" 
                            data-item-price="${item.sales_price}">
                            Select
                        </button>
                    </td>
                </tr>
            `);
        });
    }
    
    // Search items in browse modal
    $('#item_search').on('keyup', function() {
        renderItemsList($(this).val());
    });
    
    // Open browse items modal
    $(document).on('click', '.browse-items-btn', function() {
        currentItemRowIndex = $(this).closest('tr').data('row-index');
        $('#browseItemsModal').modal('show');
    });
    
    // Select item from browse modal
    $(document).on('click', '.select-browse-item', function() {
        const itemId = $(this).data('item-id');
        const itemName = $(this).data('item-name');
        const itemCode = $(this).data('item-code');
        const itemPrice = $(this).data('item-price');
        
        const row = $(`#sale_items_table tbody tr[data-row-index="${currentItemRowIndex}"]`);
        row.find('.item-id').val(itemId);
        row.find('.item-name').val(`${itemName} (${itemCode})`);
        row.find('.item-price').val(itemPrice);
        
        // Set default quantity to 1
        const quantity = row.find('.item-quantity').val() || 1;
        row.find('.item-quantity').val(quantity);
        
        // Calculate amount
        calculateRowAmount(row);
        
        $('#browseItemsModal').modal('hide');
    });
    
    // Add new item row
    $('#add_sale_item_row').on('click', function() {
        const rowCount = $('#sale_items_table tbody tr').length;
        const newRowIndex = rowCount;
        
        const newRow = `
            <tr data-row-index="${newRowIndex}">
                <td>
                    <input type="hidden" name="sale_items[${newRowIndex}][item_id]" class="item-id">
                    <input type="text" readonly class="form-control item-name" placeholder="Select Item">
                    <button type="button" class="btn btn-sm btn-secondary browse-items-btn mt-1">Browse</button>
                </td>
                <td><input type="number" class="form-control item-price" name="sale_items[${newRowIndex}][price_at_sale]" readonly></td>
                <td><input type="number" class="form-control item-quantity" name="sale_items[${newRowIndex}][quantity]" min="1" value="1"></td>
                <td><input type="number" class="form-control item-amount" name="sale_items[${newRowIndex}][amount]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item-row">Remove</button></td>
            </tr>
        `;
        
        $('#sale_items_table tbody').append(newRow);
    });
    
    // Remove item row
    $(document).on('click', '.remove-item-row', function() {
        if ($('#sale_items_table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            recalculateTotal();
        } else {
            alert('You cannot remove all rows. At least one item is required.');
        }
    });
    
    // Calculate row amount when quantity or price changes
    $(document).on('input', '.item-quantity, .item-price', function() {
        calculateRowAmount($(this).closest('tr'));
    });
    
    // Calculate single row amount
    function calculateRowAmount(row) {
        const price = parseFloat(row.find('.item-price').val()) || 0;
        const quantity = parseInt(row.find('.item-quantity').val()) || 0;
        const amount = price * quantity;
        row.find('.item-amount').val(amount.toFixed(2));
        
        recalculateTotal();
    }
    
    // Recalculate total, discount and grand total
    function recalculateTotal() {
        let totalAmount = 0;
        
        $('#sale_items_table tbody tr').each(function() {
            totalAmount += parseFloat($(this).find('.item-amount').val()) || 0;
        });
        
        $('#sale_total_amount').val(totalAmount.toFixed(2));
        
        const discount = parseFloat($('#sale_total_discount').val()) || 0;
        const grandTotal = totalAmount - discount;
        
        $('#sale_grand_total').val(grandTotal.toFixed(2));
    }
    
    // Update grand total when discount changes
    $('#sale_total_discount').on('input', function() {
        recalculateTotal();
    });
    
    // Handle form submission
    $('#save_sale_btn').on('click', function() {
        // Validate form first
        let isValid = true;
        
        if (!$('#client_name').val()) {
            alert('Please enter client name');
            isValid = false;
            return;
        }
        
        // Check if at least one item is selected
        let itemSelected = false;
        $('#sale_items_table tbody tr').each(function() {
            if ($(this).find('.item-id').val()) {
                itemSelected = true;
                return false; // Break the loop
            }
        });
        
        if (!itemSelected) {
            alert('Please select at least one item');
            isValid = false;
            return;
        }
        
        if (isValid) {
            $('#saleForm').submit();
        }
    });
});
</script>
@endpush
@endsection

@section('head')
{{-- Add any page-specific CSS here --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
