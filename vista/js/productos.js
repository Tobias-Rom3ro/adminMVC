console.log("JS cargado");
$(document).ready(function() {
    const dataTable = $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
        }
    });

    loadProducts();

    $('#btnAddProduct').on('click', function() {
        resetProductForm();
        $('#productModalTitle').text('Añadir Producto');
        $('#productForm').data('action', 'add');
        $('#productModal').modal('show');
    });

    $('#btnSaveProduct').on('click', function() {
        saveProduct();
    });

    $('#btnConfirmDelete').on('click', function() {
        deleteProduct();
    });

    $(document).on('click', '.btn-edit', function() {
        const productId = $(this).data('id');
        editProduct(productId);
    });

    $(document).on('click', '.btn-delete', function() {
        const productId = $(this).data('id');
        $('#deleteProductId').val(productId);
        $('#deleteModal').modal('show');
    });
});

function loadProducts() {
    $.ajax({
        url: '/adminMVC/controlador/action/ajax_producto.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.type === 'success') {
                displayProducts(response.productos);
            } else {
                showAlert('Error al cargar productos: ' + response.msg, 'danger');
            }
        },
        error: function(xhr, status, error) {
            showAlert('Error en la solicitud AJAX: ' + error, 'danger');
        }
    });
}

function displayProducts(products) {
    const dataTable = $('#dataTable').DataTable();
    dataTable.clear();

    products.forEach(function(product) {
        dataTable.row.add([
            product.id,
            product.nombre,
            product.descripcion,
            formatCurrency(product.precio),
            generateActionButtons(product.id)
        ]);
    });

    dataTable.draw();
}

function generateActionButtons(productId) {
    return `
        <button class="btn btn-info btn-sm btn-edit mr-1" data-id="${productId}">
            <i class="fas fa-edit"></i> Editar
        </button>
        <button class="btn btn-danger btn-sm btn-delete" data-id="${productId}">
            <i class="fas fa-trash"></i> Eliminar
        </button>
    `;
}

function formatCurrency(amount) {
    return '$ ' + parseFloat(amount).toFixed(2);
}

function resetProductForm() {
    $('#productForm')[0].reset();
    $('#productId').val('');
}

function saveProduct() {
    const productId = $('#productId').val();
    const productName = $('#productName').val();
    const productDescription = $('#productDescription').val();
    const productPrice = $('#productPrice').val();
    const action = $('#productForm').data('action');

    if (!productName || !productDescription || !productPrice) {
        showAlert('Todos los campos son obligatorios', 'warning');
        return;
    }

    $.ajax({
        url: '/adminMVC/controlador/action/ajax_save_producto.php',
        type: 'POST',
        data: {
            action: action,
            id: productId,
            nombre: productName,
            descripcion: productDescription,
            precio: productPrice
        },
        dataType: 'json',
        success: function(response) {
            if (response.type === 'success') {
                $('#productModal').modal('hide');
                loadProducts();
                showAlert(response.msg, 'success');
            } else {
                showAlert(response.msg, 'danger');
            }
        },
        error: function(xhr, status, error) {
            showAlert('Error en la solicitud AJAX: ' + error, 'danger');
        }
    });
}

function editProduct(productId) {
    $.ajax({
        url: '/adminMVC/controlador/action/ajax_get_producto.php',
        type: 'GET',
        data: { id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.type === 'success') {
                const producto = response.producto;

                $('#productId').val(producto.id);
                $('#productName').val(producto.nombre);
                $('#productDescription').val(producto.descripcion);
                $('#productPrice').val(producto.precio);

                $('#productModalTitle').text('Editar Producto');
                $('#productForm').data('action', 'update');

                $('#productModal').modal('show');
            } else {
                showAlert(response.msg, 'danger');
            }
        },
        error: function(xhr, status, error) {
            showAlert('Error en la solicitud AJAX: ' + error, 'danger');
        }
    });
}

function deleteProduct() {
    const productId = $('#deleteProductId').val();

    $.ajax({
        url: '/adminMVC/controlador/action/ajax_delete_producto.php',
        type: 'POST',
        data: { id: productId },
        dataType: 'json',
        success: function(response) {
            $('#deleteModal').modal('hide');

            if (response.type === 'success') {
                loadProducts();
                showAlert(response.msg, 'success');
            } else {
                showAlert(response.msg, 'danger');
            }
        },
        error: function(xhr, status, error) {
            $('#deleteModal').modal('hide');
            showAlert('Error en la solicitud AJAX: ' + error, 'danger');
        }
    });
}

function showAlert(message, type) {
    // Create alert element
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

    const alertContainer = $('.container-fluid').first();
    alertContainer.prepend(alertHtml);

    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}