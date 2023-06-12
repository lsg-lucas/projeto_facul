
$("#btn-clientes").on("click", function() {
    $('#clientes-tab').click();
  });

$("#btn-cadastro").on("click", function() {
  $('#cadastro-tab').click();
});

$("#btn-galeria").on("click", function() {
  $('#galeria-tab').click();
});

$(document).ready(function(){
    $('.cep').inputmask('00000-000');
    Inputmask({"mask": "(99) 99999-9999", "jitMasking": "true"}).mask('.telefone','.celular');
  });


  function validarNome(e) {
    const input = e.target;
    const tecla = e.key;
  
    if (/\d/.test(tecla)) {
      e.preventDefault();
      input.setCustomValidity('Números não são permitidos neste campo');
    } else {
      input.setCustomValidity('');
    }
  }

  function apenasNumeros(e) {
    e.target.value = e.target.value.replace(/[^\d]/g, '');
  }
  
  function formatarCEP(cep) {
    cep = cep.replace(/\D/g, ''); // remove tudo que não é dígito numérico
    cep = cep.replace(/^(\d{5})(\d)/, '$1-$2'); // adiciona o traço após o quinto dígito
    return cep;
  }
  
  function mascaraCEP(e) {
    e.target.value = formatarCEP(e.target.value);
  }

  function salvarCliente(){
    var url = "";
    var id = $('#id_cli').val();
    if (id != ''){
      url = "../../api/index.php?comando=modificar_cliente";
    }else {
      url = "../../api/index.php?comando=salvar_cliente";

    }

    $.post(url,
			$("#formulario").serializeArray(),
			// pegando resposta do retorno do post
			function (response)
			{
              if (response["codigo"] == 1) {
                  $('.limpar').val('');
                Swal.fire({
                  icon: 'success',
                  title: 'Sucesso!',
                  text: 'Registro Salvo com Sucesso!',
                  showConfirmButton: false,
                  timer: 2500
                });

                } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Erro!',
                  text: 'Erro ao executar a operação!',
                  showConfirmButton: false,
                  timer: 2500
                });
				}
			}
			, "json" // definindo retorno para o formato json
		);
  }
  
  async function buscarEnderecoPorCEP(cep) {
    try {
      const url = `https://viacep.com.br/ws/${cep}/json/`;
      const response = await fetch(url);
      const endereco = await response.json();
  
      if (endereco.erro) {
        throw new Error('CEP não encontrado');
      }
  
      return endereco;
    } catch (error) {
      console.error(error.message);
    }
  }
  
  const campoCEP = document.querySelector('#cep');
  const campoLogradouro = document.querySelector('#logradouro');
  const campoBairro = document.querySelector('#bairro');
  const campoCidade = document.querySelector('#cidade');
  const campoEstado = document.querySelector('#estado');
  
  campoCEP.addEventListener('blur', async () => {
    const cep = campoCEP.value;
    const endereco = await buscarEnderecoPorCEP(cep);
  
    campoLogradouro.value = endereco.logradouro;
    campoBairro.value = endereco.bairro;
    campoCidade.value = endereco.localidade;
    campoEstado.value = endereco.uf;
  });
  
  var botao = $("#btn-clientes");
  var conteudo = $("#clientes-lista");
