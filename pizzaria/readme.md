# Pizzaria

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Implementa API de pizzaria:
-CRUD de clientes; 
-CRUD de pizzas; 
-Criar pedido; 

## Especificações

* PHP 7.4
* Composer

## Execução

1. `composer install` 
2. `php -S localhost:8000 -t public` 

### Banco de dados

O BD SQLITE configurado ja está com Clients e Pizzas geradas pelas seeds para demonstração, caso necessário resetar:
`php artisan migrate:fresh` 

## Testes

`composer run test` 

## Observações

1. Optei por usar Lumen por ser uma versão do Laravel otimizada para APIs em microserços;
2. Como se trata de um teste adicionei o .env ao projeto com as configurações para teste local;

## Api

### Clients Collection [/clients]

#### List All Clients [GET]

* Response 200 (application/json)

``` json
    [
        {
            "id": 1,
            "name": "Mr. Richie Renner",
            "phone_number": "94018189",
            "address": "760 Kemmer Road\nNorth Halberg, VT 52816",
            "reference": null,
            "created_at": "2020-01-31 21:48:57"
        }
    ]
```

#### Create a New Client [POST]

* Request (application/json)

``` json
    {
        "name": "Mr. Richie Renner",
        "phone_number": "940181893",
        "address": "760 Kemmer Road\nNorth Halberg, VT 52816",
        "reference": "Corner with the westside"
    }
```

* Response 201 (application/json)

    - Body

``` json
    {
        "id": 1,
        "name": "Mr. Richie Renner",
        "phone_number": "940181893",
        "address": "760 Kemmer Road\nNorth Halberg, VT 52816",
        "reference": null,
        "created_at": "2020-01-31 21:48:57"
    }
```

#### Update a Client [PUT]

* Request (application/json)

``` json
    {
        "name": "Mr. Steve Jobs",
    }
```

* Response 200 (application/json)

    - Body

``` json
    {
        "id": 1,
        "name": "Mr. Steve Jobs",
        "phone_number": "940181893",
        "address": "760 Kemmer Road\nNorth Halberg, VT 52816",
        "reference": null,
        "created_at": "2020-01-31 21:48:57"
    }
```

#### Delete a Client [DELETE]

* Response 204 (application/json)

#### List All Client Orders [GET][/clients/{id}/orders]

* Response 200 (application/json)

    - Body

``` json
    [
      {
        "id": 6,
        "client": "Steve Jobs",
        "status": 0,
        "arrival": "15:52",
        "total": 944.74,
        "pizzas": [
          {
            "id": 4,
            "pizza": "et sit natus",
            "size": "large",
            "qty": 7,
            "price": 119.01
          },
          {
            "id": 10,
            "pizza": "numquam sit quidem",
            "size": "medium",
            "qty": 2,
            "price": 47.01
          }
        ],
        "note": "Wonderland, though she knew she had but to get."
      }
    ]
```

