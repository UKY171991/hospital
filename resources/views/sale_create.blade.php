@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Add/Update Sale Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add/Update Sale</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sale.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}">
                        </div>
                    </div>
                </div>

                <hr>

                <h6>Items</h6>
                <table class="table table-bordered" id="items_table">
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
                        <!-- Item rows will be added here by JavaScript -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-info btn-sm" id="add_item_row">Add Item</button>

                <hr>

                <div class="row mt-3">
                    <div class="col-md-6 offset-md-6">
                        <div class="form-group row">
                            <label for="total_amount" class="col-sm-4 col-form-label">Total Amount</label>
                            <div class="col-sm-8">
                                <input type="number" readonly class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_discount" class="col-sm-4 col-form-label">Discount</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="total_discount" name="total_discount" value="{{ old('total_discount', 0) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="grand_total" class="col-sm-4 col-form-label">Grand Total</label>
                            <div class="col-sm-8">
                                <input type="number" readonly class="form-control" id="grand_total" name="grand_total" value="{{ old('grand_total', 0) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="remark">Remark</label>
                    <textarea class="form-control" id="remark" name="remark" rows="3">{{ old('remark') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Sale</button>
                <a href="{{ route('sale.manage') }}" class="btn btn-secondary">Sale List</a>
            </form>
        </div>
    </div>
</div>

<!-- Modal for selecting items -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Select Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="item_search" class="form-control mb-2" placeholder="Search items...">
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
                    <tbody id="modal_items_list">
                        <!-- Items will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Check 1: Is Bootstrap's Modal class available?
    if (typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {
        console.error('Bootstrap Modal class is not available. Check Bootstrap JS inclusion in layouts/admin.blade.php.');
        alert('Critical Error: Bootstrap Modal functionality is not loaded. Please check the browser console for details.');
        // Disable buttons that trigger modals as a precaution
        $('.browse-items-btn').prop('disabled', true).text('Modal JS Error');
        return; // Stop further execution of this script if Bootstrap Modal is not found
    }

    let items = @json($items);
    // Check 2: Is the items data valid?
    if (!items || typeof items.filter !== 'function') {
        console.error('Items data is not available or not in expected format (array).', items);
        // You might want to inform the user or handle this case gracefully
        // For now, we'll allow the script to continue but modal item population will fail.
    }

    let selectedItemIndex = 0;
    const addItemModalEl = document.getElementById('addItemModal');

    // Check 3: Is the modal HTML element present in the DOM?
    if (!addItemModalEl) {
        console.error('Modal HTML element with ID #addItemModal not found in the DOM.');
        alert('Critical Error: The modal's HTML structure (#addItemModal) is missing from sale_create.blade.php. Please check console.');
        $('.browse-items-btn').prop('disabled', true).text('Modal HTML Error');
        return; // Stop further execution if modal element is missing
    }

    const itemModal = bootstrap.Modal.getOrCreateInstance(addItemModalEl);

    function renderModalItems(searchTerm = '') {
        const modalItemsList = $('#modal_items_list');
        modalItemsList.empty(); // Clear previous items

        if (!items || typeof items.filter !== 'function') {
            console.warn('Cannot render modal items because items data is invalid.');
            modalItemsList.html('<tr><td colspan="5" class="text-center text-danger">Error: Item data could not be loaded.</td></tr>');
            return;
        }

        const filteredItems = items.filter(item =>
            item.item_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            item.item_code.toLowerCase().includes(searchTerm.toLowerCase())
        );

        if (filteredItems.length === 0) {
            modalItemsList.html('<tr><td colspan="5" class="text-center">No items match your search or no items available.</td></tr>');
            return;
        }

        filteredItems.forEach(item => {
            modalItemsList.append(`
                <tr>
                    <td>${item.item_name}</td>
                    <td>${item.item_code}</td>
                    <td>${item.sales_price}</td>
                    <td>${item.current_stock}</td>
                    <td><button type="button" class="btn btn-primary btn-sm select-item-btn" data-item-id="${item.id}">Select</button></td>
                </tr>
            `);
        });
    }

    $('#item_search').on('keyup', function() {
        renderModalItems($(this).val());
    });

    $('#add_item_row').on('click', function() {
        const rowIndex = $('#items_table tbody tr').length;
        const newRow = `
            <tr data-row-index="${rowIndex}">
                <td>
                    <input type="hidden" name="sale_items[${rowIndex}][item_id]" class="item-id">
                    <input type="text" readonly class="form-control item-name" placeholder="Select Item">
                    <button type="button" class="btn btn-sm btn-secondary browse-items-btn mt-1">Browse</button>
                </td>
                <td><input type="number" class="form-control item-price" name="sale_items[${rowIndex}][price_at_sale]" readonly></td>
                <td><input type="number" class="form-control item-quantity" name="sale_items[${rowIndex}][quantity]" min="1" value="1"></td>
                <td><input type="number" class="form-control item-amount" name="sale_items[${rowIndex}][amount]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-item-row">Remove</button></td>
            </tr>
        `;
        $('#items_table tbody').append(newRow);
    });

    $(document).on('click', '.browse-items-btn', function() {
        console.log('.browse-items-btn clicked. Attempting to open modal.');
        if (!itemModal) {
            console.error('itemModal instance is not available when .browse-items-btn was clicked.');
            alert('Error: Modal instance is not ready. Check console.');
            return;
        }
        selectedItemIndex = $(this).closest('tr').data('row-index');
        renderModalItems(); // Populate modal content
        try {
            itemModal.show();
            console.log('itemModal.show() called successfully.');
        } catch (e) {
            console.error('Error calling itemModal.show():', e);
            alert('An error occurred while trying to show the modal: ' + e.message);
        }
    });

    $(document).on('click', '.select-item-btn', function() {
        const itemId = $(this).data('item-id');
        const selectedItem = items.find(item => item.id == itemId);
        const targetRow = $(`#items_table tbody tr[data-row-index="${selectedItemIndex}"]`);

        targetRow.find('.item-id').val(selectedItem.id);
        targetRow.find('.item-name').val(selectedItem.item_name + ' (' + selectedItem.item_code + ')');
        targetRow.find('.item-price').val(selectedItem.sales_price);
        targetRow.find('.item-quantity').val(1); // Default quantity to 1
        calculateRowAmount(targetRow);
        itemModal.hide();
    });

    $(document).on('click', '.remove-item-row', function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    $(document).on('input', '.item-quantity, .item-price', function() {
        const row = $(this).closest('tr');
        calculateRowAmount(row);
    });

    $('#total_discount').on('input', function() {
        calculateTotals();
    });

    function calculateRowAmount(row) {
        const price = parseFloat(row.find('.item-price').val()) || 0;
        const quantity = parseInt(row.find('.item-quantity').val()) || 0;
        const amount = price * quantity;
        row.find('.item-amount').val(amount.toFixed(2));
        calculateTotals();
    }

    function calculateTotals() {
        let totalAmount = 0;
        $('#items_table tbody tr').each(function() {
            totalAmount += parseFloat($(this).find('.item-amount').val()) || 0;
        });
        $('#total_amount').val(totalAmount.toFixed(2));

        const discount = parseFloat($('#total_discount').val()) || 0;
        const grandTotal = totalAmount - discount;
        $('#grand_total').val(grandTotal.toFixed(2));
    }

    if ($('#items_table tbody tr').length === 0 && items && items.length > 0) {
        // $('#add_item_row').click(); // Optionally auto-add first row if needed
    } else if ($('#items_table tbody tr').length === 0) {
        // If no items in table and no items to select, maybe show a message or just one empty row
         $('#add_item_row').click(); 
    }
});
</script>
@endpush
