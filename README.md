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

**Validações parte 3 - Validando parâmetros e a importância do Accept**
- Headers
    - Content-Type | application/x-www-form-urlencoded
    - Accept | application/json

**Validações parte 4 - Regras de validação no Update - Lidando com o Unique**
- Unique
    - 1) Tabela
    - 2) Nome da coluna que será pesquisado na tabela
    - 3) ID do registro que será desconsiderado na pesquisa

**Upload de arquivos - Implementando o upload de imagens parte 1**

```php
$request->nome;
$request->get('nome');
$request->input('nome');

$request->imagem;
$request->file('imagem');
```

**Implementando o upload de imagens parte 2**
- Disk - config/filesystems.php
    - local -> /storage/app/
    - public -> /storage/app/public/
    - AWS S3 -> cloud

**Implementando o upload de imagens parte 3**

```php
$marca = $this->marca->create([
    'nome' => $request->nome,
    'imagem' => $imagem_urn
]);

$marca->nome = $request->nome;
$marca->imagem = $imagem_urn;
$marca->save();
```

**Upload de arquivos - Criando um link simbólico para o disco public**

```php
php artisan storage:link
```

**Configurando o Vue.JS no Laravel**

Iniciar o projeto Laravel
```
composer create-project --prefer-dist laravel/laravel=8.5.9 
```

Instalar o pacote UI
```
composer require laravel/ui:^3.2.1
```

Gerar o esqueleto do projeto com Vue.JS e autenticação web nativa (scaffold / esqueleto)
```php
php artisan ui vue --auth
```

Baixar as dependências de front-end
```
npm install
```

Produzindo o bundle de front-end
```
npm run dev
```
