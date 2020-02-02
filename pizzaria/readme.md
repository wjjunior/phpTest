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
        "name": "Mr. Steve Jobs"
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

### Pizzas Collection [/pizzas]

#### List All Pizzas [GET]

* Response 200 (application/json)

``` json
    [
      {
        "id": 1,
        "name": "dolorem natus quaerat",
        "description": "This did not like to try the thing at all. However, 'jury-men' would have done  just as I'd taken the highest tree in the shade: however, the moment she quite forgot you didn't     like cats.' 'Not like.",
        "small": 83.89,
        "medium": 93.89,
        "large": 103.89,
        "created_at": "2020-01-31 21:48:57"
      }
    ]
```

#### Create a New Pizza [POST]

* Request (application/json)

``` json
    {
	    "name": "Calabresa",
	    "description": "Linguiça calabresa, cebola e azeitona",
	    "small": "25",
	    "medium": "35",
	    "large": "45"
    }
```

* Response 201 (application/json)

    - Body

``` json
    {
        "id": 21,
        "name": "Calabresa",
        "description": "Linguiça calabresa, cebola e azeitona",
        "small": 25,
        "medium": 35,
        "large": 45,
        "created_at": "2020-02-02 15:26:40"
    }
```

#### Update a Pizza [PUT]

* Request (application/json)

``` json
    {
	    "small": 26.5,
	    "medium": 36.5,
	    "large": 46.5
    }
```

* Response 200 (application/json)

    - Body

``` json
    {
        "id": 1,
        "name": "dolorem natus quaerat",
        "description": "This did not like to try the thing at all. However, 'jury-men' would have done just     as I'd taken the highest tree in the shade: however, the moment she quite forgot you didn't like      cats.' 'Not like.",
        "small": 26.5,
        "medium": 36.5,
        "large": 46.5,
        "created_at": "2020-01-31 21:48:57"
    }
```

#### Delete a Pizza [DELETE]

* Response 204 (application/json)

### Orders Collection [/orders]

#### List All Orders [GET]

* Response 200 (application/json)

``` json
    [
        {
            "id": 1,
            "client": "Gia Blanda",
            "status": 0,
            "arrival": "16:24",
            "total": 763.91,
            "pizzas": [
                {
                    "id": 1,
                    "pizza": "dolorem natus quaerat",
                    "size": "large",
                    "qty": 6,
                    "price": 46.5
                },
                {
                    "id": 13,
                    "pizza": "quidem quasi fugit",
                    "size": "large",
                    "qty": 6,
                    "price": 65.06
                },
                {
                    "id": 20,
                    "pizza": "ea doloremque quos",
                    "size": "large",
                    "qty": 1,
                    "price": 79.04
                }
            ],
            "note": "I to get out again. Suddenly she came upon a."
        }
    ]
```

#### Create a New Order [POST]

* Request (application/json)

``` json
    {
	    "client_id": 9,
	    "delivery_time": 20,
	    "pedido": [
		{
		    "pizza_id": 10,
		    "size": "medium",
		    "qty": 1
		},
		{
			"pizza_id": 9,
			"size": "large",
			"qty": 12
		}
	]
    }
```

* Response 201 (application/json)

    - Body

``` json
    {
        "id": 22,
        "client": "Dock Heidenreich",
        "status": 0,
        "arrival": "16:08",
        "total": 801.69,
        "pizzas": [
            {
                "id": 10,
                "pizza": "numquam sit quidem",
                "size": "medium",
                "qty": 1,
                "price": 47.01
            },
            {
                "id": 9,
                "pizza": "pariatur velit necessitatibus",
                "size": "large",
                "qty": 12,
                "price": 62.89
            }
        ],
  "note": null
}
```

#### Update an Order [PUT]

* Request (application/json)

``` json
    {
	    "delivery_time": 50,
	    "note": "Motoboy atrasou",
	    "status": 1
    }
```

* Response 200 (application/json)

    - Body

``` json
    {
        "id": 1,
        "client": "Gia Blanda",
        "status": 1,
        "arrival": "16:40",
        "total": 763.91,
        "pizzas": [
            {
                "id": 1,
                "pizza": "dolorem natus quaerat",
                "size": "large",
                "qty": 6,
                "price": 46.5
            },
            {
                "id": 13,
                "pizza": "quidem quasi fugit",
                "size": "large",
                "qty": 6,
                "price": 65.06
            },
            {
                "id": 20,
                "pizza": "ea doloremque quos",
                "size": "large",
                "qty": 1,
                "price": 79.04
            }
        ],
        "note": "Motoboy atrasou"
    }
```

#### Delete an Order [DELETE]

* Response 204 (application/json)

#### Add a new pizza to the Order [PUT][/orders/pizza/add/{id}]

* Request (application/json)

``` json
    {
	    "pedido": [
		    {
		        "pizza_id": 1,
		        "size": "large",
		        "qty": 10
		    },
		    {
		        "pizza_id": 2,
		        "size": "small",
		        "qty": 3
		    }
	    ]
    }
```

* Response 200 (application/json)

    - Body

``` json
    {
        "id": 2,
        "client": "Rogers Romaguera",
        "status": 0,
        "arrival": "17:06",
        "total": 2029.82,
        "pizzas": [
            {
                "id": 5,
                "pizza": "veritatis deserunt alias",
                "size": "medium",
                "qty": 19,
                "price": 100.47
            },
            {
                "id": 2,
                "pizza": "quam et quidem",
                "size": "small",
                "qty": 3,
                "price": 39.24
            }
        ],
        "note": "Pigeon, raising its voice to its children, 'Come."
    }
```

#### Remove a pizza from the Order [PUT][/orders/pizza/remove/{id}]

* Request (application/json)

``` json
    {
	    "pizza_id": 1,
	    "size": "large",
	    "qty": 6
    }
```

* Response 200 (application/json)

    - Body

``` json
    {
        "id": 1,
        "client": "Gia Blanda",
        "status": 0,
        "arrival": "17:22",
        "total": 484.91,
        "pizzas": [
            {
                "id": 13,
                "pizza": "quidem quasi fugit",
                "size": "large",
                "qty": 6,
                "price": 65.06
            },
            {
                "id": 20,
                "pizza": "ea doloremque quos",
                "size": "large",
                "qty": 1,
                "price": 79.04
            }
        ],
        "note": "I to get out again. Suddenly she came upon a."
    }
```

