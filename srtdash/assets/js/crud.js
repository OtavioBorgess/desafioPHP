//CRUD PRODUCT
$(document).on('submit', '#saveProduct', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('save_product', "true");

    $.ajax({
        method: 'POST',
        url: 'cadastroProduto.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    setTimeout($('#modalAdicionarProduto').modal('hide'), 2000);
                    $('#table_product').load(' #table_product');
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('click', '.btnEditProduct', function () {

    let idProduto = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'getProduto.php?id=' + idProduto,
        data: {idProduto: idProduto},
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#idProduct').val(res.id);
                $('#descricao').val(res.descricao);
                $('#preco').val(res.preco);
                $('#unidade').val(res.unidade);
                $('#estoque').val(res.estoque);

                $('#modalEditProduct').modal('show');

            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('submit', '#updateProduct', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('update_product', 'true');

    $.ajax({
        method: 'POST',
        url: 'editarProduto.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    $('#updateProduct')[0].reset();
                    setTimeout($('#modalEditProduct').modal('hide'), 2000);
                    $('#table_product').load(' #table_product');
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

function delProduto(id, p_name) {
    Swal.fire({
        title: "Tem certeza?",
        text: `Você apagará o produto: ${p_name}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Apagar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "excluirProduto.php",
                type: "POST",
                data: {p_id: id},
                dataType: "json",
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#table_product').load(' #table_product');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                }
            });
        }
    });
}

//UPDATE PASSWORD

$(document).on('submit', '#editarSenha', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('update_password', "true");

    $.ajax({
        method: 'POST',
        url: 'alterarSenha.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    location.href = 'index.php';
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

// UPDATE PERFIL
$(document).on('submit', '#updatePerfil', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('update_perfil', "true");

    $.ajax({
        method: 'POST',
        url: 'editarPerfil.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

//VERIFY LOGIN
$(document).on('submit', '#verifyLogin', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('verify_login', 'true');

    $.ajax({
        method: 'POST',
        url: 'verificarLogin.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    location.href = 'painel.php'
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

//ADDED USER
$(document).on('submit', '#saveUser', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('save_user', 'true');

    $.ajax({
        method: 'POST',
        url: 'cadastroUsuario.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    location.href = 'index.php'
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

//CRUD PRODUCT-FEIRA
$(document).on('click', '.btnAddProductFeira', function () {

    const idFeira = $(this).val();

    $.ajax({
        method: 'GET',
        url: 'getFeira.php',
        data: {
            idFeira: idFeira
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#idFeira').val(res.id);
                $('#modalAddProductFeira').modal('show');
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('change', '#idProduto', function (e) {
    e.preventDefault();

    const idProduto = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'getProduto.php',
        data: {
            idProduto: idProduto
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#idProduto').val(res.id);
                $('#descricao').val(res.descricao);
                $('#preco').val(res.preco);
                $('#unidade').val(res.unidade);
                $('#estoque').val(res.estoque);
                $('#quantidade').attr('max', res.estoque);
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('submit', '#addProductFeira', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("addProductFeira", "true");

    $.ajax({
        method: 'POST',
        url: 'adicionarProdutoFeira.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    $('#tableViewProduct').load(' #tableViewProduct');
                    $('#modalAddProductFeira').modal('hide');
                    $('#modalViewProductFeira').modal('show');
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('click', '.btnViewProductFeira', function () {
    const idFeira = $(this).val();

    $.ajax({
        method: 'GET',
        url: 'getFeira.php',
        data: {
            idFeira: idFeira
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#modalViewProductFeira').modal('show');
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('click', '.btnEditProductFeira', function () {
    const productFeira_id = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'getProdutoFeira.php',
        data: {
            productFeira_id: productFeira_id
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#idProductFeira').val(res.id);
                $('#idEditProduto').val(res.idProduto);
                $('#editIdFeira').val(res.idFeira);
                $('#editDescricao').val(res.descricao);
                $('#editPreco').val(res.preco);
                $('#editUnidade').val(res.unidade);
                $('#editQuantidade').val(res.quantidade).attr('max', res.estoque + res.quantidade);
                $('#editEstoque').val(res.estoque);
                $('#modalEditProductFeira').modal('show');
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('submit', '#updateProductFeira', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("update_productFeira", "true");

    $.ajax({
        method: 'POST',
        url: 'editarProdutoFeira.php',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    $('#tableViewProduct').load(' #tableViewProduct');
                    $('#modalEditProductFeira').modal('hide');
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

function delProductFeira(prodFeira_id, descricao) {
    Swal.fire({
        title: "Tem certeza?",
        text: `Você apagará o produto: ${descricao}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Apagar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "excluirProdutoFeira.php",
                type: "POST",
                data: {prodFeira_id: prodFeira_id},
                dataType: "json",
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $('#tableViewProduct').load(' #tableViewProduct');
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                }
            });
        }
    });
}

//REMOVER ITEMPEDIDO DA CESTA
function delItemPedido(item_id, descricao) {
    Swal.fire({
        icon: "warning",
        text: `Remover o produto (${descricao}) da sua cesta?`,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Remover",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "removerItemPedido.php",
                type: "POST",
                data: {item_id: item_id},
                dataType: "json",
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                }
            });
        }
    });
}

//EDIT ITEMPEDIDO
$(document).on('click', '.btnEditItem', function () {

    const idItem = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'getItem.php',
        data: {
            idItem: idItem
        },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('#editItem_id').val(res.id);
                $('#editItem_descricao').val(res.descricao);
                $('#editItem_prodQuantidade').val(res.prodQuantidade);
                $('#editItem_itemQuantidade').val(res.itemQuantidade).attr('max', res.prodQuantidade + res.itemQuantidade);
                $('#editItem_Unidade').text(`(${res.unidade})`);
                $('#editItemPreco').val(res.preco);

                $("#modalEditItem").modal('show');
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});

$(document).on('submit', '#updateItem', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("update_item", "true");

    $.ajax({
        method: 'POST',
        url: 'editarItemPedido.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    $('#table_item').load(' #table_item');
                    $('#modalEditItem').modal('hide');
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        }
    });
});
