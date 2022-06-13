Necessário estar com a coluna `validate_login` da tabela PERFIS como 1 para validar o login;

Também é necessário ter um computador vinculado ao usuário, adicionando o `hostname` e `uuid` para este computador, buscando essas informações através dos seguintes comandos:

`wmic csproduct get "UUID" → uuid`

`hostname → hostname`

Necessário criar uma pasta dentro de C:\ chamada wms e colocar o arquivo de configuração que esta na pasta  /validade_login na raiz do projeto, segue exemplo de parâmetros config:

```json
{
    "link": "http://lgb-wms-dev.sistemasloginfo.com.br/",
    "version": "89.0.4389.23",
    "user": "CPF_USER",
    "pass": "PASSWORD_USER"
}
```

Para re-gerar o executável basta rodar o comando a seguir:

`pyinstaller --onefile login_validate.py`

E após isto, copiar o executável dentro da pasta dist e jogar para a pasta /validade_login na raiz do projeto WMS