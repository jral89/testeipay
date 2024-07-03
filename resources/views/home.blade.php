@include('includes.header')

    <style>
        .box-com-borda {
            border: 1px solid #ccc;
            padding: 20px;
        }
    </style>


    <div class="container">
        <div class="col-12 mt-3">
            <table id="tabela-cpfs" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>cpf</th>
                    <th>nome</th>
                    <th>sobrenome</th>
                    <th>nascimento</th>
                    <th>email</th>
                    <th>genero</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($cpfs as $cpf)
                    <tr>
                        <td>{{ $cpf->cpf }}</td>
                        <td>{{ $cpf->nome }}</td>
                        <td>{{ $cpf->sobrenome }}</td>
                        <td class="data_nascimento">{{ $cpf->nascimento }}</td>
                        <td>{{ $cpf->email }}</td>
                        <td>{{ $cpf->genero }}</td>
                        <td><a href="javascript:;" onclick="deletaCad('{{ $cpf->cpf }}')"><i class="fa-solid fa-trash"></i></a></td>
                        <td><a href="javascript:;" onclick="alteraCad('{{ $cpf->cpf }}')"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<script>

    function deletaCad(cpf){
        console.log(cpf);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('cpf.deletar') }}',
            method: 'POST',
            data: {
                cpf: cpf,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response.delete);
                if(response.delete === 'true'){
                    alert('CPF excluido com sucesso');
                    location.reload();
                } else {
                    alert('CPF já cadastrado');
                }
            }
        });
    };

    function alteraCad(cpf){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ route('pagina.update') }}',
            method: 'get',
            data: {
                cpf: cpf,
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                // if(response.delete === 'true'){
                //     alert('CPF excluido com sucesso');
                //     location.reload();
                // } else {
                //     alert('CPF já cadastrado');
                // }
            }
        });
    };

</script>
