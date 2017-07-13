DOCKER ROCKMONGO
================

## What is Rockmongo?
RockMongo is a MongoDB administration tool, written in PHP 5, very easy to install and use. 
https://github.com/iwind/rockmongo

This docker image is built on an Alpine Linux image, using **lighttpd** server.

## Run the container
The image is automatically built from this repository and it is available at https://hub.docker.com/r/tadaweb/rockmongo/.

```bash
docker run -d --name rockmongo -e MONGO_HOSTS=mongo1.host1:27017,mongo2.host2:27017,mongo3.host3:27018 -p 8050:8060 tadaweb/rockmongo:1.1.7
```

## Environment variables
| Variable | default value | description |
| -------- | ------------- | ----------- |
| MONGO_HOSTS | localhost:27017 | A comma separated list of hosts and port. They will be displayed as connections to Mongodb |
| ROCKMONGO_PORT | 8060 | The default lighttpd server listening port |
| MONGO_HIDE_SYSTEM_COLLECTIONS | false | Do not hide Mongodb system collection such as **admin** and **local** |
| MONGO_AUTH | false | Use mongodb authentication instead of rockmongo control users |
| MONGO_USER | -     | It works only if MONGO_AUTH enabled |
| MONGO_PASSWORD | - | It works only if MONGO_AUTH enabled |
| ROCKMONGO_USER | admin | It works only if MONGO_AUTH is disabled and represnts the rockmongo control user |
| ROCKMONGO_PASSWORD | admin | It works only if MONGO_AUTH is disabled and represents the rockmongo control user's password |

## CHANGE BEHAVIOUR
You can modifify and load the **config.php** file. Once modifiled mount the file in docker with the option  

```bash
-v `pwd`/config.php:/var/www/localhost/rockmongo/config.php 
```
