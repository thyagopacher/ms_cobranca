# Projeto backend API

https://kanastra.notion.site/Hiring-Challenge-Soft-Engineers-Fullstack-Live-or-Take-home-Version-02bd3892c6b946e1b0b801f64638fb25

## Requerimentos

Instalar dependencias relacionadas no composer pelo bash do docker

```
    composer install
```

## Para criar novas migrations 

```
php artisan make:migration importacao
```

O comando irá criar a tabela migrations no banco:

```
php artisan migrate:install
```

## Rotas importantes

UPload do arquivo para processamento da cobrança
/cobranca/salvar-arquivo