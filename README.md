
Criar o database
./vendor/bin/doctrine-module orm:schema-tool:create

Atualizar entidades
./vendor/bin/doctrine-module orm:generate-entities /c/Servidor/www/serasa/modelo_test

Gerar repositorios
./vendor/bin/doctrine-module  orm:generate:repositories /c/Servidor/www/serasa/modelo_test