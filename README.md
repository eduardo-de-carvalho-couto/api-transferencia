# Bem vindo(a) ao projeto Api-Transferencia

Nesta API utilizei conceitos de clean architecture, atentando à inversão de dependência, dividindo a aplicação em domínio, aplicação e infra. Também utilizei symfony para a criação dos endponts.

> Status: Developing ⚠️

## Sobre o que é o projeto ?

CRUD de usuarios, do tipo Pessoa e Lojista, de um sistema financeiro que realiza transferência.

## Instrução para rodar o projeto

1. Clone o repositório
```
git clone https://github.com/eduardo-de-carvalho-couto/api-transferencia
```
2. Instale as dependências
```
composer install
```

### Se for de sua preferência utilizar Docker, isso aqui pode ajudar

```
alias composer='docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html composer composer'
```
```
alias php='docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html php php'
```
```
docker run -itv $(pwd):/app -w /app -p 8080:8080 php -S 0.0.0.0:8080 -t public
```

## Primeiramente faça um registro de Pessoa ou Loja

No path /pessoas ou /lojas com o verbo HTTP POST

### Payload para o registro de Pessoa. Coloque o Cpf no documento
```JSON
{
    "documento": "847.138.675-81",
    "nome": "tom bombadil",
    "email": "tom@bombador.com",
    "senha": "12345678"
}
```

### Payload para o registro de Loja. Coloque o Cnpj no documento
```JSON
{
    "documento": "77.999.555/0001-99",
    "nome": "Teste Loja",
    "email": "loja@exemplo.com",
    "senha": "12345678"
}
```

## Faça o login e gere o Token JWT

No Path /login, no caso do usuario do tipo Pessoa, envie
```JSON
{
    "cpf": "847.138.675-81",
    "senha": "12345678"
}
```
E no caso de Loja, envie
```JSON
{
    "cnpj": "77.999.555/0001-99",
    "senha": "12345678"
}
```

## Utilize o JWT para ter acesso a todos os outros paths

Buscar Pessoas:
```
/pessoas
```
Buscar Pessoa:
```
/pessoas/{id}
```
Atualizar Pessoa:
```
/pessoas/{id}
```
Remover Pessoa
```
/pessoas/{id}
```
Buscar Lojas:
```
/lojas
```
Buscar Loja:
```
/lojas/{id}
```
Atualizar Loja:
```
/lojas/{id}
```
Remover Loja:
```
/lojas/{id}
```

## Planos para este projeto

Usuarios do tipo Pessoa poderão pagar e receber. Lojistas só poderão receber.



