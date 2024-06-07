# Crawling Application

Uma base de aplicação laravel, com Docker, Nginx e Mysql que executa um crawling lendo a tela de uma pagina e retorna dados de cotações.

## Tecnologias

- PHP 8.3
- MySQL
- nginx
- Laravel 11
- Docker
- git

## Como utilizar:

- Clone o projeto
    `git clone https://github.com/EliasFernandes03/Crawling-Laravel.git`

- Agora entre na pasta com o terminal 
    `cd setup-laravel-docker`

- Utilize o docker para executar isso 
    `docker-compose up -d`


## Instalar

- Entre no container
    `docker-compose exec php bash`

- Execute o composer install
    `composer install`

- Execute as migrations
    `php artisan migrate`


### Rotas


#### Get Currency
- **BaseUrl:** `http://localhost:8080/api`
- **Endpoint:** `GET /currency/{codes}`
- **Descrição:** Busca uma currency e salva na tabela os dados do retorno
  - **Parâmetros de URL:**
  - `/{codes}` Uma lista de codigos, `USD,BRL` por exemplo
- **Retorno esperado:**
```
[
    {
        "code": "AED",
        "decimals": "784",
        "numeric": "2",
        "name": "Dirham dos Emirados"
    },
    {
        "code": "USD",
        "decimals": "840",
        "numeric": "2",
        "name": "Dólar americano"
    }
]
```
#### Get All Data
- **BaseUrl:** `http://localhost:8080/api/`
- **Endpoint:** `GET /getdata`
- **Descrição:** Retorna todos os dados da tabela
- **Retorno esperado:**
```
[
    {
        "code": "AED",
        "decimals": "784",
        "numeric": "2",
        "name": "Dirham dos Emirados"
    },
    {
        "code": "USD",
        "decimals": "840",
        "numeric": "2",
        "name": "Dólar americano"
    }
]
```

#### Get One Data
- **BaseUrl:** `http://localhost:8080/api/`
- **Endpoint:** `GET /getdata`
- **Descrição:** Retorna todos os dados da tabela
- **Retorno esperado:**
```
[
    {
        "code": "AED",
        "decimals": "784",
        "numeric": "2",
        "name": "Dirham dos Emirados"
    },
    {
        "code": "USD",
        "decimals": "840",
        "numeric": "2",
        "name": "Dólar americano"
    }
]
```

#### Get Currency
- **BaseUrl:** `http://localhost:8080/api`
- **Endpoint:** `GET /getone?code=USD&date=2024-06-07`
- **Descrição:** Busca uma currency do banco 
  - **Parâmetros de URL:**
  - `/{code}` Um codigo, `USD` e `/{date}` uma data em  `2024-06-07`
- **Retorno esperado:**
```
{
    "code": "AED",
    "decimals": "784",
    "numeric": "2",
    "name": "Dirham dos Emirados"
}
```

## Testes

- Entre no container
    `docker-compose exec php bash`

- Execute o composer install
    `vendor/bin/phpunit`
