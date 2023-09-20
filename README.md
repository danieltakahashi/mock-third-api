## How to use

### Creating Container

In the initial stages, to make the calls, you will need to create a container of that service

In container_name, change to the service you want (sample-external.api.com)

```
services:
    nginx:
        image: nginx:stable-alpine
        container_name: sample-external.api.com
        networks:
            - project_default
        ports:
            - 8888:80
        volumes:
            - ./src:/var/www/html/src
            - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
```

finally, execute `docker compose up -d --build`

### Creating directories

In the data folder, create a new one, with the same name as the container name,
and create a data.json file to be used internally by the code.

```
data/sample-external.api.com/data.json 
```

### Calling the endpoint

With the folders created, and the container running, use some tool like postaman,
or just, via cmd, give the endpoint a curl. For example

`sample-external.api.com/test1`

Note that `test1` is the **path** that was previously defined in the data.json file,
within the folder of the defined domain.

```
    {
        "method": "GET",
        "path": "/test1",
        "response": {
            "statusCode": 202,
            "body": {
                "result_code": 1234,
                "result_message": "test1 working"
            }
        }
    },
```

