# Quadro Societário

Esse projeto é um desafio feito pela VoxTecnologia para o processo de admissão para integração do time de desenvolvedores.

## Vamos lá

1. Para começarmos precisaremos do Docker Compose instalado, pode encontrá-lo [aqui](https://docs.docker.com/compose/install/)
2. Rode o comando `docker compose build --no-cache` para construir as imagens novas
3. Rode o comando `docker compose up --pull always -d --wait` para iniciar o projeto
4. Rode o comando `docker compose exec php composer install` para instalar as dependências do projeto
5. Nesse projeto apenas foi realizada a parte da API, portanto pode acessar `https://localhost/ping` para garantir o funcionamento do projeto
6. Para finalizar rode `docker compose down --remove-orphans` para parar todos os Containers

## Sobre o que foi feito

Fiz os CRUDs para Empresas e Sócios, aqui nomeei em inglês como "Organization" e "Associate", respectivamente.
Mantive o padrão de projeto limpo seguindo os conceitos apresentados na documantação do Symfony.
As rotas estão descritas dentro dos Controllers respectivos, e também podem ser acessados via o comando `docker compose exec php php bin/console debug:router`.
Trabalhei com os padrões de API Rest.

## Considerações

* Essa imagem Docker está documentada no site oficial do Symfony, pode achar mais sobre [aqui](https://github.com/dunglas/symfony-docker).
* Considerando que tudo correu bem para iniciar o projeto, os dois principais comandos são:
    * `docker compose exec php` para interagir com o Container do PHP;
    * `docker compose exec database psql -U app -d app` para visualizar o Banco de Dados.
* Relatando sobre o desenvolvimento:
    * Foi bem tranquilo, apesar de eu ter bem mais experiência em Laravel, já tive algum contato com Symfony.
    * Apesar do projeto em si ter ficado simples, creio que consegui demonstrar meu padrão de código.
* Por fim, agradeço a oportunidade.

**Obrigado!**
