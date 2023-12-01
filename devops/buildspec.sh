#!/bin/bash

THE_DATE=$(date '+%Y-%m-%d %H:%M:%S')
echo "Build started on $THE_DATE"

if [ "$TF_VAR_ENV_APP_GL_SCRIPT_MODE" == "clouddocker" ] 
then

    . ./devops/build_clouddocker.sh

elif [ "$TF_VAR_ENV_APP_GL_SCRIPT_MODE" == "cloudeks" ] 
then
 
    . ./devops/build_cloudeks.sh

else

    . ./devops/build_cloud.sh

fi