#!/bin/bash

THE_DATE=$(date '+%Y-%m-%d %H:%M:%S')
echo "Build started on $THE_DATE"

appenvsubstr(){
    p_template=$1
    p_destination=$2
    envsubst '$TF_VAR_ENV_APP_GL_SCRIPT_MODE' < $p_template \
    | envsubst '$TF_VAR_ENV_APP_GL_NAME' \
    | envsubst '$TF_VAR_ENV_APP_GL_STAGE' \
    | envsubst '$TF_VAR_ENV_APP_BE_DOMAIN_NAME' \
    | envsubst '$TF_VAR_ENV_APP_BE_URL' \
    | envsubst '$TF_VAR_ENV_APP_BE_LOCAL_PORT' \
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
chmod 777 devops/appspec.sh