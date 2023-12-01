#!/bin/bash

THE_DATE=$(date '+%Y-%m-%d %H:%M:%S')
echo "Build started on $THE_DATE"

if [ "$TF_VAR_ENV_APP_GL_SCRIPT_MODE" == "CLOUDOCKER" ] 
then

    . build_cloud_docker.sh

elif [ "$TF_VAR_ENV_APP_GL_SCRIPT_MODE" == "CLOUDEKS" ] 
then
 
    . build_cloud_eks.sh

else

    . build_cloud.sh

fi