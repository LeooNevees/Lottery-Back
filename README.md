# Inicialização:
    1 - Necessário ter Docker e Docker-Compose instalados na máquina;
    2 - Entrar na pasta raiz do projeto e executar o seguinte comando pelo terminal:

docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/var/www/html \
-w /var/www/html \
laravelsail/php81-composer:latest \
composer install --ignore-platform-reqs 

    3 - Ainda no terminal, rodar o comando para iniciar a aplicação: ./vendor/bin/sail up -d
    4 - Em seguida, ainda no terminal, rodar o comando para configurar o banco de dados: ./vendor/bin/sail artisan migrate:fresh --seed
    5 - Para finalizar a aplicação, rodar o comando: ./vendor/bin/sail stop