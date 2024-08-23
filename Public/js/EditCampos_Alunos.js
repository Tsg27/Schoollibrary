$(document).ready(function() {
    // Captura o evento de clique no botão "Editar"
    $('.editarUsuario').on('click', function() {
        
        // Obtém os dados do atributo "data" da linha da tabela
        const codAluno = $(this).closest('tr').find('td:eq(0)').text();
        const matricula = $(this).closest('tr').find('td:eq(1)').text();
        const nome = $(this).closest('tr').find('td:eq(2)').text();
        const telefone = $(this).closest('tr').find('td:eq(3)').text();
        const email = $(this).closest('tr').find('td:eq(4)').text();
      

        // Preenche os campos do formulário de edição
        $('#idAluno').val(codAluno);
        $('#matricula').val(matricula);
        $('#editarNome').val(nome);
        $('#editarTelefone').val(telefone);
        $('#editarEmail').val(email);
         
            
    });
});