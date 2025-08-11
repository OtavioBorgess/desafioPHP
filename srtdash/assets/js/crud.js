
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
        confirmButtonText: "Sim, apagar!",
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