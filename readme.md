# Teste prático

## O teste foi desenvolvido em algumas partes

> Backend e Frontend criados de maneiras independentes.

### Para criação do sistema foi utilizado um gerenciador de rotas [coffeecode/router](https://packagist.org/packages/coffeecode/router)

### Para geração de excel foi utilizado a biblioteca [phpoffice/phpSpreadsheet](https://phpspreadsheet.readthedocs.io/en/latest/)

* A biblioteca necessita que o ext-GD esteja habilitado no PHP.ini  

### Para geração de pdf foi utilizado a biblioteca [mpdf](https://mpdf.github.io/)

> O frontend foi criado consumindo a API

> Para cada requisição feita para o backend, foi utilizado uma autenticação por header http basic, utilizando uma base64 do array com usuário e senha logado a cada requisição, validado se o usuário é valido ou não.

> Usuário para acessar o sistema
> - Usuário: matheusv 
> - Senha: 123 

```
 Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.0.30
 Versão do cliente de banco de dados: libmysql - mysqlnd 8.0.30
 Extensão do PHP: mysqli Documentação curl Documentação mbstring Documentação
 Versão do PHP: 8.0.30

- Tipo de conexão ao banco de dados: localhost
- Nome da base de dados: db_easy_20240410
- Usuário para conexão: db_easy_admin
- Senha para conexão: z@5ApM!tZDQDkxq]
```
