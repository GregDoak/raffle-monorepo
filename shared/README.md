# Shared

The `shared` directory contains infrastructure shared by the components of the Raffle application.

## Services

### PostgreSQL

The shared environment provides a PostgreSQL database using the Alpine-based PostgreSQL image.

The database credentials can be configured using environment variables set in the root `.env` file or fallback to the following defaults:

| Variable                    | Default     | Description                         |
|-----------------------------|-------------|-------------------------------------|
| `HOST_SHARED_DATABASE_PORT` | `5432`      | Host port used to access PostgreSQL |
| `SHARED_DATABASE_USER`      | `user`      | PostgreSQL user                     |
| `SHARED_DATABASE_PASSWORD`  | `password`  | PostgreSQL password                 |

## Database Persistence

PostgreSQL uses a Docker named volume called `postgres` to store its data.

Stopping the services does not remove this volume, so database data is retained when the containers are stopped and started again.

Destroying the environment will permanently remove the data.

## Docker Network

The shared services are connected to a Docker network named `shared`.

This network provides a common network boundary for infrastructure that will be used by the application as the project develops.

## Starting the Shared Services

From the root of the repository, the shared services can be started using:

```shell
make shared/start
```

To stop the services:

```shell
make shared/stop
```

To destroy the shared environment:

```shell
make shared/destroy
```

The available Make targets can be viewed with:

```shell
make help
```

The commands above delegate to the Makefile associated with the shared infrastructure.

## Configuration

The shared services can be configured through environment variables. A template for the project's environment configuration is provided at the repository level.
