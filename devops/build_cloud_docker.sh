#!/bin/bash

appenvsubstr(){
    p_template=$1
    p_destination=$2
    envsubst '$TF_VAR_ENV_APP_GL_SCRIPT_MODE' < $p_template \
    | envsubst '$TF_VAR_ENV_APP_GL_NAMESPACE' \
    | envsubst '$TF_VAR_ENV_APP_GL_NAME' \
    | envsubst '$TF_VAR_ENV_APP_GL_STAGE' \
    | envsubst '$TF_VAR_ENV_APP_GL_REPO_PHP_NAME' \
    | envsubst '$TF_VAR_ENV_APP_GL_REPO_PHP_TAG' \
    | envsubst '$TF_VAR_ENV_APP_GL_DOCKER_REPOSITORY' \
    | envsubst '$TF_VAR_ENV_APP_GL_AWS_REGION' \
    | envsubst '$TF_VAR_ENV_APP_BE_DOMAIN_NAME' \
    | envsubst '$TF_VAR_ENV_APP_BE_URL' \
    | envsubst '$TF_VAR_ENV_APP_BE_LOCAL_PORT' \
    | envsubst '$TF_VAR_ENV_APP_BE_LOCAL_SOURCE_FOLDER' \
    | envsubst '$TF_VAR_ENV_APP_DB_HOST' \
    | envsubst '$TF_VAR_ENV_APP_DB_PORT' \
    | envsubst '$TF_VAR_ENV_APP_DB_NAME' \
    | envsubst '$TF_VAR_ENV_APP_DB_USERNAME' \
    | envsubst '$TF_VAR_ENV_APP_DB_PASSWORD' > $p_destination
}

mkdir -p tmp
chmod 777 tmp

appenvsubstr devops/000-default.conf.template 000-default.conf
appenvsubstr devops/ports.conf.template ports.conf
appenvsubstr devops/dir.conf.template dir.conf
appenvsubstr devops/appspec.yml.template appspec.yml
appenvsubstr devops/.env.example.template .env
appenvsubstr devops/appspec.sh.template devops/appspec.sh
appenvsubstr devops/Dockerfile.template Dockerfile
appenvsubstr devops/docker-compose.yml.template docker-compose.yml
chmod 777 devops/appspec.sh
