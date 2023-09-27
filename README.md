## How to use

### Creating Container

First, you will need to create a `docker-compose.override.yml`
```
version: '3.8'

services:
  nginx:
    container_name: domain.sample
    networks:
      - my_application_default

  php:
    networks:
      - my_application_default

networks:
  my_application_default:
    external: true
```
In `container_name`, change to the domain you want (domain.sample)

And change the `networks` that is in use in your application.

Finally, execute 
```
docker-compose up -d --build
```

### Creating directories

In the data folder, create a new one, with the same name as the `container_name`,
and create a data.json file to be used internally by the code.

```
data/domain.sample/data.json 
```

### Calling the endpoint

In you application, you can check if it's working, example via bash:
```
curl -k -s https://domain.sample/test1
```

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

