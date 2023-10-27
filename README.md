
###  Agenda API (PHP 8 | Laravel 10 | Docker | Swagger | PHPUnit)

## Configuração do Ambiente:

#### Criar .env:
```cp .env.example .env```

#### Rodar o projeto usando o Docker:
```docker-compose up -d --build```

#### Acessar container docker:
```docker exec -it agenda_api_php bash```

#### Instalar as dependências com o Composer:
```composer install```

#### Gerar a chave do projeto:
```php artisan key:generate```

#### Executar as migrations (tabelas do banco de dados):
```php artisan migrate```

#### Verificar PSR-12:
```composer check-psr12```

#### Rodar os casos de testes de integração:
```composer test tests/Integration```

#### Atualizar documentação da API com Swagger:
```php artisan swagger```

#### Link para visualizar a documentação do API gerada pelo Swagger
```http://0.0.0.0:8080/api-documentation/index.html```

=====================================================

# Endpoints da API:

##  Criar novo usuário:
###### Método: POST
###### Endpoint: /api/usuarios/cadastrar
###### Corpo da Requisição:
```
{
    "nome": "Luigi",
    "email": "email@email.com",
    "password": "123456"
}
```

## Fazer login:
###### Método: POST
###### Endpoint: /api/auth/login
###### Corpo da Requisição:
```
{
    "email": "email@email.com",
    "password": "123456"
}
```

## Fazer logout:
###### Método: POST
###### Endpoint: /api/auth/logout

## Adicionar agenda:
###### Método: POST
###### Endpoint: /api/v1/agendas/adicionar
##### Corpo da Requisição:
```
{
    "titulo": "Evento importante",
    "descricao": "Teste",
    "data_inicio": "2024-11-07",
    "data_prazo": "2024-11-08",
    "status": 1,
    "tipo_atividade_id": 1
}
```

## Atualizar agenda:
###### Método: PUT
###### Endpoint: /api/v1/agendas/1/atualizar
###### Corpo da Requisição:
```
{
    "titulo": "Evento Atualizado",
    "descricao": "Teste",
    "data_inicio": "2023-11-27",
    "data_prazo": "2023-11-30",
    "usuario_id": 12,
    "status": 1,
    "tipo_atividade_id": 1
}
```

## Filtrar agendas:
###### Método: POST
###### Endpoint: /api/v1/agendas/filtrar
###### Corpo da Requisição:
```
{
   "data_inicio": "2023-11-01",
   "data_prazo": "2023-11-30"
}
```

## Desabilitar agenda:
###### Método: DELETE
###### Endpoint: /api/v1/agendas/3/remover
