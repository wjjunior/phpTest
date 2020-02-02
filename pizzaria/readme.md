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
- PHP 7.4
- Composer

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
