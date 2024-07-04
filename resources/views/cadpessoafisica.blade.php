@include('includes.header')

<div class="container">
    <h2>Cadastro Pessoa Fisica</h2>
    <div class="col-12">
        <form action="" id="form_cpf" method="POST">
            <div class="form-group">
                <label for="cpf">cpf:</label>
                <input type="text" minlength="14" maxlength="14" class="form-control" id="cpf" placeholder="Digite o cpf" required>
            </div>
            <div class="form-group">
                <label for="nome">nome:</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome" required>
            </div>
            <div class="form-group">
                <label for="sobrenome">sobrenome:</label>
                <input type="text" class="form-control" id="sobrenome" placeholder="Digite o sobrenome" required>
            </div>
            <div class="form-group">
                <label for="nascimento">nascimento:</label>
                <input  type="date" class="form-control" id="nascimento" placeholder="Digite o nascimento" required>
            </div>
            <div class="form-group">
                <label for="email">email:</label>
                <input type="email" class="form-control" id="email" placeholder="Digite o email" required>
            </div>
            <div class="form-group">
                <label for="genero">genero:</label>
                <select name="genero" class="form-control" id="genero" placeholder="Digite o genero" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>
            <input type="button" onclick="resetaFormulario()" class="btn btn-primary" value="Reiniciar">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

</div>

</body>
</html>

<script>

    $(document).ready(function(){
        $('#cpf').inputmask('999.999.999-99');
    });

    function validaCPF(cpf) {
        var Soma = 0
        var Resto

        var strCPF = String(cpf).replace(/[^\d]/g, '')

        if (strCPF.length !== 11){
            return false;
        }

        if ([
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999',
        ].indexOf(strCPF) !== -1){
            return false;
        }

        for (i=1; i<=9; i++){
            Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
        }

        if ((Resto == 10) || (Resto == 11)){
            Resto = 0;
        }

        if (Resto != parseInt(strCPF.substring(9, 10)) ){
            return false;
        }

        Soma = 0;

        for (i = 1; i <= 10; i++){
            Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
        }

        if ((Resto == 10) || (Resto == 11)){
            Resto = 0;
        }

        if (Resto != parseInt(strCPF.substring(10, 11) ) ){
            return false;
        }

        return true;
    }

    function validadata(){
        var data = document.getElementById("nascimento").value;
        data = data.replace(/\//g, "-");
        var data_array = data.split("-");

        if(data_array[0].length != 4){
            data = data_array[2]+"-"+data_array[1]+"-"+data_array[0];
        }

        var hoje = new Date();
        var nasc  = new Date(data);
        var idade = hoje.getFullYear() - nasc.getFullYear();
        var m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;

        if(idade < 18){
            alert("Pessoas menores de 18 não podem se cadastrar.");
            return false;
        }

        if(idade >= 18 && idade <= 60){
            return true;
        }

        return false;
    }

    function resetaFormulario(){
        document.getElementById("form_cpf").reset();
    }

    document.getElementById('form_cpf').addEventListener('submit', function(event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var cpf = document.getElementById('cpf').value;
        var nome = document.getElementById('nome').value;
        var sobrenome = document.getElementById('sobrenome').value;
        var nascimento = document.getElementById('nascimento').value;
        var email = document.getElementById('email').value;
        var genero = document.getElementById('genero').value;
        var strCPF = String(cpf).replace(/[^\d]/g, '');
        let cpfValido = validaCPF(cpf);
        let nascimentoValido = validadata();

        if (strCPF.length !== 11){
            Swal.fire({
                title: "preencha seu cpf completo.",
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            if(cpfValido == true && nascimentoValido == true){
                var rotas = [
                    '{{ route('cpf.cadastrar') }}',
                    'https://api-teste.ip4y.com.br/cadastro',
                ];

                for(link = 0; link < rotas.length; link++){
                    $.ajax({
                        url: rotas[link],
                        method: 'POST',
                        data: {
                            cpf: cpf,
                            nome: nome,
                            sobrenome: sobrenome,
                            nascimento: nascimento,
                            email: email,
                            genero: genero
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.cadastro);
                            if(response.cadastro === 'true'){
                                Swal.fire({
                                    title: "CPF cadastrado com sucesso.",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "CPF já cadastrado.",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });
                }
            } else {
                Swal.fire({
                    title: "digite um cpf e/ou data de nascimento válidos",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        }
    });
</script>
