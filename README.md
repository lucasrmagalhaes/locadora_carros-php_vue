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

**Configurando a conexão com o banco de dados e implementando as migrations**

```sql
CREATE DATABASE lc;
```

```php
php artisan migrate
```

**Entendendo o grupo de rotas Web e API e a importância do Content-Type**
- Response
    - Headers
        - Content-Type
            - text/html
            - application/json

```
http://127.0.0.1:8000/api/
```

**Rotas e a diferença entre Route::resource e Route::apiResource**

```
php artisan route:list
```

**Criando registros via POST**

```sql
USE LC;
DESCRIBE marcas;
SELECT * FROM marcas;
```

**Atualizando registros via PUT e PATCH**
- PUT utilizado para atualizar todos os campos.
- PATCH utilizado para atualizar um campo específico.

**Entendendo o conceito de endpoint (URL, URN e URI)**
- URL - Uniform Resource Locator
    - Host onde está o recurso.
- URN - Uniform Resource Name
    - Recurso dentro do host.
- URI - Uniform Resource Identifier
    - Combinação do protocolo + URL + URN