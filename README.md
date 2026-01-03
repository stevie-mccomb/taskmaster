# TaskMaster

## Setup Requirements
- Docker: [https://www.docker.com/](https://www.docker.com/)
- Node: [https://nodejs.org/en](https://nodejs.org/en)
- Composer: [https://getcomposer.org/](https://getcomposer.org/)

## Quickstart
Run the following command on your terminal to clone the project, move into it, install dependencies, and start the Docker container.
```
git clone git@github.com:stevie-mccomb/taskmaster.git && cd taskmaster && composer install && npm i && npm run build && cp .env.example .env && php artisan key:generate && ./vendor/bin/sail up -d && echo 'Waiting for server to boot...' && sleep 10 && ./vendor/bin/sail artisan migrate
```

## Long-form Setup Instructions
1. Clone the project: `git clone git@github.com:stevie-mccomb/taskmaster.git`
1. Install dependencies: `composer install && npm i`
1. Build front-end assets: `npm run build`
1. Spin up local server: `./vendor/bin/sail up -d`
1. Populate the database: `./vendor/bin/sail artisan migrate` (Note that you may have to wait a few moments for the local server to fully boot up before running this command.)
1. View page in browser at: `http://localhost`

## Usage Instructions
1. Create an account by visiting `http://localhost/register` or by clicking "Don't have an account?" from the login form.
1. Create a project using the "Create Project" form that is presented after account creation.
1. Use the task board to create, update, delete, and reorganize tasks.

## FAQs
- Why is an account required?
    - Tasks require projects and projects require a user so that projects and tasks are never orphaned.
- Why am I seeing a "Connection Refused" error when attempting to run the "Quickstart" command?
    - It's possible that your local Sail server has not fully booted and the MySQL service is not yet running. Wait a few moments and try resuming the setup instructions starting at "Long-form Setup Instructions -> 5. (Populate the Database)".