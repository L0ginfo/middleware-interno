# WMS

Projeto / WMS

[![Build Status](https://api.travis-ci.org/cakephp/app.png)](https://travis-ci.org/cakephp/app)
[![License](https://poser.pugx.org/cakephp/app/license.svg)](https://packagist.org/packages/cakephp/app)

## Documentação
- [Pré-requisitos](https://github.com/L0ginfo/pontaNegra#user-content-pré-requisitos) 
- [Instalação do Projeto](https://github.com/L0ginfo/pontaNegra#user-content-instalação-do-projeto) 
- [Execução do Webpack](https://github.com/L0ginfo/pontaNegra#user-content-execucao-do-webpack)
- [Instalação do Git Flow](https://github.com/L0ginfo/pontaNegra#user-content-instalação-do-git-flow)

## Pré-requisitos


## Instalação do Projeto

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) ou atualize `composer self-update`.

2. Clone o projeto, executando:

```bash
git clone https://github.com/L0ginfo/pontaNegra.git
```

3. Com o projeto baixado, execute:

```bash
composer install
```

4. Com o projeto baixado, duplique e renomeie os arquivos:
- `config/.env.sample` para `config/.env`

5. Após configurar o arquivo `.env`, execute o comando abaixo para rodar as `Migrations`:

```bash
vendor/bin/phinx migrate
```

Obs: Caso ocorra erro ao rodar as `Migrations` prosseguir como a execução das `Seeds` e rodar individualmente as `Migrations` que deram erro, com o comando abaixo:

```bash
vendor/bin/phinx migrate -t 20110103081132 (PREFIXO DA MIGRATION)
```

6. Após rodar as `Migrations`, execute o comando abaixo para rodar as `Seeds`:


```bash
vendor/bin/phinx run:seed
```


7. Na pasta webroot, executar o comando:

```bash
npm install
```

## Execução do Webpack

Para compilar os arquivos `SASS` e `JS`, executar o comando:

```bash
npm run watch
```

## Instalação do Git Flow

1. Para iniciar o Git Flow, execute: `git flow init`
2. Em [branch production], digite: `master`
3. Em [branch "next releases"], digite: `premaster`
4. Para as demais perguntas, pressione: `Enter`