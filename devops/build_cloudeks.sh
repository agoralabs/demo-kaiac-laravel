#!/bin/bash

THE_DATE=$(date '+%Y-%m-%d %H:%M:%S')
echo "Build started on $THE_DATE"

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
    | envsubst '$TF_VAR_ENV_APP_GL_AWS_REGION_ECR' \
    | envsubst '$TF_VAR_ENV_APP_BE_DOMAIN_NAME' \
    | envsubst '$TF_VAR_ENV_APP_BE_URL' \
    | envsubst '$TF_VAR_ENV_APP_BE_LOCAL_PORT' \
    | envsubst '$TF_VAR_ENV_APP_BE_LOCAL_SOURCE_FOLDER' \
    | envsubst '$TF_VAR_ENV_APP_BE_EKS_CLUSTER_NAME' \
    | envsubst '$TF_VAR_ENV_APP_BE_KUBERNETES_NAMESPACE' \
    | envsubst '$TF_VAR_ENV_APP_BE_SSL_CERT_ARN' \
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
appenvsubstr devops/appspec_cloudeks.sh.template devops/appspec.sh
appenvsubstr devops/Dockerfile.template Dockerfile
appenvsubstr devops/laravel-kubernetes.yaml.template laravel-kubernetes.yaml
appenvsubstr devops/laravel-service.yaml.template laravel-service.yaml

chmod 777 devops/appspec.sh

echo "Login into ecr..."
aws ecr get-login-password --region $TF_VAR_ENV_APP_GL_AWS_REGION_ECR | docker login --username AWS --password-stdin $TF_VAR_ENV_APP_GL_DOCKER_REPOSITORY

echo "Building the Docker image..."
docker build -t $TF_VAR_ENV_APP_GL_NAME:$TF_VAR_ENV_APP_GL_NAMESPACE'_'$TF_VAR_ENV_APP_GL_NAME .

echo "Create $TF_VAR_ENV_APP_GL_NAME repository..."
aws ecr describe-repositories --repository-names $TF_VAR_ENV_APP_GL_NAME || aws ecr create-repository --repository-name $TF_VAR_ENV_APP_GL_NAME

echo "Tag your image with the Amazon ECR registry..."
docker tag $TF_VAR_ENV_APP_GL_NAME:$TF_VAR_ENV_APP_GL_NAMESPACE'_'$TF_VAR_ENV_APP_GL_NAME $TF_VAR_ENV_APP_GL_DOCKER_REPOSITORY/$TF_VAR_ENV_APP_GL_NAME:$TF_VAR_ENV_APP_GL_NAMESPACE'_'$TF_VAR_ENV_APP_GL_STAGE

echo "Push the image to ecr..."
docker push $TF_VAR_ENV_APP_GL_DOCKER_REPOSITORY/$TF_VAR_ENV_APP_GL_NAMESPACE:$TF_VAR_ENV_APP_GL_NAMESPACE'_'$TF_VAR_ENV_APP_GL_STAGE

echo "Updating kubeconfig..."
aws eks update-kubeconfig --region $TF_VAR_ENV_APP_GL_AWS_REGION --name $TF_VAR_ENV_APP_BE_EKS_CLUSTER_NAME

cat laravel-kubernetes.yaml
cat laravel-service.yaml

echo "Trying kubectl apply -f laravel-kubernetes.yaml..."
kubectl apply -f laravel-kubernetes.yaml -n ${TF_VAR_ENV_APP_BE_KUBERNETES_NAMESPACE}

echo "Trying kubectl apply -f laravel-service.yaml..."
kubectl apply -f laravel-service.yaml -n ${TF_VAR_ENV_APP_BE_KUBERNETES_NAMESPACE}

THE_DATE_END=$(date '+%Y-%m-%d %H:%M:%S')
echo "Build ended on $THE_DATE_END"