# FalaQ - Projeto Laravel base para a 3ª Etapa

Rode os comandos a baixo no terminal na sua pasta de documentos para clonar e configurar o repositório
```sh
git clone https://github.com/nato-re/falaq-base.git
cd falaq-base
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```


## Sprint 07 — Sistema de Moderação

Implementados migration e model de moderações, FormRequest, controller, rotas autenticadas, Policy para o dono do evento e tela da fila.

Após configurar o `.env`, execute `php artisan migrate`. Eventos criados por usuários autenticados recebem `user_id`; eventos antigos sem proprietário precisam ter o proprietário definido para liberar a fila de moderação.
