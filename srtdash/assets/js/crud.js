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
                dataType: "html",
                success: function (response) {
                    $("#products").html(response);
                    Swal.fire(
                        'Deletado!',
                        `O produto "${p_name}" foi deletado.`,
                        'success'
                    );
                },
                error: function () {
                    Swal.fire(
                        'Erro!',
                        'Não foi possível deletar o produto.',
                        'error'
                    );
                }
            });
        }
    });
}
