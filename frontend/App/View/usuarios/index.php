<div class="p-2 d-flex flex-column" style="gap: 1rem">
  <div class="d-flex flex-row justify-content-between align-items-center">
    <h3><i class="bi bi-people-fill"></i> Lista de Usuários</h3>
    <button class="btn btn-success" data-toggle="modal" data-target="#modal-form"><i class="bi bi-person-fill-add text-lg"></i></button>
  </div>

  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">Função</th>
        <th scope="col">Nome</th>
        <th scope="col">RG</th>
        <th scope="col">CPF</th>
        <th scope="col">Endereço</th>
        <th scope="col">Opções</th>
      </tr>
    </thead>
    <tbody id="userlist">

    </tbody>
  </table>
</div>
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal_editar" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="title-modal">Editar</h5>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="id_usuario" name="id_usuario">
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: John doe">
            </div>
            <div class="form-group col-md-4">
              <label for="id_funcao">Função</label>
              <select id="id_funcao" name="id_funcao" class="form-control">
                <option>Selecione...</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nome_usuario">Usuário</label>
              <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="usuário">
            </div>
            <div class="form-group col-md-6">
              <label for="senha">Senha</label>
              <input type="password" class="form-control" id="senha" name="senha" placeholder="senha">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="rua">Rua</label>
              <input type="text" class="form-control" id="rua" name="rua" placeholder="Rua X">
            </div>
            <div class="form-group col-md-2">
              <label for="numero">Número</label>
              <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº 1234">
            </div>
            <div class="form-group col-md-4">
              <label for="cep">CEP</label>
              <input type="text" class="form-control" id="cep" name="cep" placeholder="12345-678">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="bairro">Bairro</label>
              <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Centro">
            </div>
            <div class="form-group col-md-4">
              <label for="cidade">cidade</label>
              <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Taubaté">
            </div>
            <div class="form-group col-md-4">
              <label for="uf">UF</label>
              <select id="uf" name="uf" class="form-control">
                <option>Selecione...</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="rg">RG</label>
              <input type="text" class="form-control" id="rg" name="rg">
            </div>
            <div class="form-group col-md-6">
              <label for="cpf">CPF</label>
              <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
          </div>
          <button type="button" class="btn btn-success" id="btn-form"></button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-deleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deletar Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Você está prestes a deletar o usuario <b class="title_user"></b></p>
        <p>Deseja continuar?</p>
        <input type="hidden" name="id_usuario_delete" id="id_usuario_delete">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="DeletarUsuario()">Deletar</button>
      </div>
    </div>
  </div>
</div>

<script>
  function ListarUsuarios() {
    $.ajax({
      url: "https://localhost/easy-users/backend/api/usuarios/listar/",
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      success: data => {

        const response = JSON.parse(data)

        if (response.code == 401) {
          alert(data.message)
          window.location.href = "https://localhost/easy-users/frontend/logout/"
        }


        let html = ``;
        response.data.forEach(user => {
          const disabledEdit = user.nome_usuario == "[USUARIO_LOGADO]" ? '' : 'disabled'
          // const disabledEdit = ""
          html += `
          <tr>
            <th scope="row">${user.nome}</th>
            <td>${user.nome_funcao}</td>
            <td>${user.rg}</td>
            <td>${user.cpf}</td>
            <td>${user.rua}, Nº ${user.numero} - ${user.cep}, ${user.cidade}/${user.uf}</td>
            <td> 
              <button class="btn btn-warning" ${disabledEdit} data-record-id="${user.id}" data-toggle="modal" data-target="#modal-form"><i class="bi bi-pencil-square"></i></button>
              <button class="btn btn-danger" data-record-title="${user.nome}" data-record-id="${user.id}" data-toggle="modal" data-target="#modal-delete"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          `;
        })

        $("#userlist").html(html)
      }
    })
  }

  $('#modal-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();

    $(".title_user").html(data.recordTitle)
    $("#id_usuario_delete").val(data.recordId)

  });

  $('#modal-form').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();

    const tituloBotao = data.recordId ? "Salvar" : "Cadastrar"
    const tituloModal = data.recordId ? "Alterar usuário" : "Cadastrar usuário"

    if (data.recordId) {
      $("#btn-form").attr("onclick", "EditarUsuario()")
    } else {
      $("#btn-form").attr("onclick", "CadastrarUsuario()")
    }


    $("#btn-form").html(tituloBotao)
    $(".title-modal").html(tituloModal)

    if (data.recordId) {
      carregarDadosUsuario(data.recordId)
    } else {
      CarregarUF('')
    }

  });


  function carregarDadosUsuario(id) {
    $.ajax({
      url: `https://localhost/easy-users/backend/api/usuario/${id}/`,
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      success: data => {
        const response = JSON.parse(data)

        $("#id_usuario").val(response.data.id)
        $("#nome").val(response.data.nome)
        $("#nome_usuario").val(response.data.nome_usuario)
        $("#rua").val(response.data.rua)
        $("#numero").val(response.data.numero)
        $("#cep").val(response.data.cep)
        $("#bairro").val(response.data.bairro)
        $("#cidade").val(response.data.cidade)
        $("#uf").val(response.data.uf)
        $("#rg").val(response.data.rg)
        $("#cpf").val(response.data.cpf)
        $("#id_funcao").val(response.data.id_funcao)
      }
    })
  }

  function CarregarUF() {
    const ufs = [{
        uf: 'AC',
        label: 'Acre '
      },
      {
        uf: 'AL',
        label: 'Alagoas '
      },
      {
        uf: 'AP',
        label: 'Amapá '
      },
      {
        uf: 'AM',
        label: 'Amazonas '
      },
      {
        uf: 'BA',
        label: 'Bahia '
      },
      {
        uf: 'CE',
        label: 'Ceará '
      },
      {
        uf: 'DF',
        label: 'Distrito Federal '
      },
      {
        uf: 'ES',
        label: 'Espírito Santo '
      },
      {
        uf: 'GO',
        label: 'Goiás '
      },
      {
        uf: 'MA',
        label: 'Maranhão '
      },
      {
        uf: 'MT',
        label: 'Mato Grosso '
      },
      {
        uf: 'MS',
        label: 'Mato Grosso do Sul '
      },
      {
        uf: 'MG',
        label: 'Minas Gerais '
      },
      {
        uf: 'PA',
        label: 'Pará '
      },
      {
        uf: 'PB',
        label: 'Paraíba '
      },
      {
        uf: 'PR',
        label: 'Paraná '
      },
      {
        uf: 'PE',
        label: 'Pernambuco '
      },
      {
        uf: 'PI',
        label: 'Piauí '
      },
      {
        uf: 'RJ',
        label: 'Rio de Janeiro '
      },
      {
        uf: 'RN',
        label: 'Rio Grande do Norte '
      },
      {
        uf: 'RS',
        label: 'Rio Grande do Sul '
      },
      {
        uf: 'RO',
        label: 'Rondônia '
      },
      {
        uf: 'RR',
        label: 'Roraima '
      },
      {
        uf: 'SC',
        label: 'Santa Catarina '
      },
      {
        uf: 'SP',
        label: 'São Paulo '
      },
      {
        uf: 'SE',
        label: 'Sergipe '
      },
      {
        uf: 'TO',
        label: 'Tocantins '
      },
    ]

    let html = '<option>Selecione...</option>'
    ufs.forEach(estado => {
      html += `<option value="${estado.uf}">${estado.label}</option>`
    })

    $("#uf").html(html);

  }

  function CarregarFuncoes() {
    $.ajax({
      url: `https://localhost/easy-users/backend/api/funcoes/listar/`,
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      success: data => {
        const response = JSON.parse(data)


        let html = '<option>Selecione...</option>'
        response.data.forEach(funcao => {
          html += `<option value="${funcao.id}">${funcao.nome_funcao}</option>`
        })

        $("#id_funcao").html(html);
      }
    })
  }

  function EditarUsuario() {

    const userId = $("#id_usuario").val()
    $.ajax({
      url: `https://localhost/easy-users/backend/api/usuario/${userId}/`,
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      method: 'PUT',
      data: {
        id: userId,
        nome: $("#nome").val(),
        nome_usuario: $("#nome_usuario").val(),
        senha: $("#senha").val(),
        rua: $("#rua").val(),
        numero: $("#numero").val(),
        cep: $("#cep").val(),
        bairro: $("#bairro").val(),
        cidade: $("#cidade").val(),
        uf: $("#uf").val(),
        rg: $("#rg").val(),
        cpf: $("#cpf").val(),
        id_funcao: $("#id_funcao").val(),
      },
      success: data => {
        const response = JSON.parse(data)

        if (response.code == 200) {
          alert("Usuário alterado com sucesso");
          window.location.reload()
        } else {
          alert(response.message);
        }
      }
    })


  }

  function CadastrarUsuario() {
    $.ajax({
      url: `https://localhost/easy-users/backend/api/usuario/`,
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      method: 'POST',
      data: {
        nome: $("#nome").val(),
        nome_usuario: $("#nome_usuario").val(),
        senha: $("#senha").val(),
        rua: $("#rua").val(),
        numero: $("#numero").val(),
        cep: $("#cep").val(),
        bairro: $("#bairro").val(),
        cidade: $("#cidade").val(),
        uf: $("#uf").val(),
        rg: $("#rg").val(),
        cpf: $("#cpf").val(),
        id_funcao: $("#id_funcao").val(),
      },
      success: data => {
        const response = JSON.parse(data)

        if (response.code == 200) {
          alert("Usuário cadastrado com sucesso");
          window.location.reload()
        } else {
          alert(response.message);
        }
      }
    })
  }

  function DeletarUsuario() {

    const userId = $("#id_usuario_delete").val()

    $.ajax({
      url: `https://localhost/easy-users/backend/api/usuario/${userId}`,
      headers: {
        'Authorization': 'Basic [TOKEN]',
      },
      method: 'DELETE',
      success: data => {
        const response = JSON.parse(data)

        if (response.code == 200) {
          alert("Usuário deletado com sucesso");
          window.location.reload()
        } else {
          alert(response.message);
        }
      }
    })
  }

  $(document).ready(function() {
    ListarUsuarios();
    CarregarUF();
    CarregarFuncoes();
  });
</script>