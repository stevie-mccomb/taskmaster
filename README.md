# TaskMaster

## Setup Requirements
- Docker: [https://www.docker.com/](https://www.docker.com/)
- Node: [https://nodejs.org/en](https://nodejs.org/en)
- Composer: [https://getcomposer.org/](https://getcomposer.org/)

## Quickstart
Run the following command on your terminal to clone the project, move into it, install dependencies, and start the Docker container.
```
git clone git@github.com:stevie-mccomb/taskmaster.git && cd taskmaster && composer install && npm i && npm run build && cp .env.example .env && php artisan key:generate && ./vendor/bin/sail up -d
```

## Long-form Setup Instructions
1. Clone the project: `git clone git@github.com:stevie-mccomb/taskmaster.git`
1. Install dependencies: `composer install && npm i`
1. Build front-end assets: `npm run build`
1. Spin up local server: `./vendor/bin/sail up -d`
1. View page in browser at: `http://localhost`