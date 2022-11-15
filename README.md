### Locadora de Carros

**Iniciando o projeto Locadora de Carros**

```
composer create-project --prefer-dist laravel/laravel app_locadora_carros "8.5.9"
composer create-project --prefer-dist laravel/laravel=8.5.9 app_locadora_carros
```

[packagist.org](https://packagist.org/packages/laravel/laravel)

```
cd app_locadora_carros
```

```php
php artisan serve
```

**Criando os models, controllers e migrations**

Marca
```
php artisan make:model --migration --controller --resource Marca
```

Modelo
```
php artisan make:model -mcr Modelo
```

Carro
```
php artisan make:model --all Carro
```

Cliente
```
php artisan make:model -a Cliente
```

Locação
```
php artisan make:model -a Locacao
```

