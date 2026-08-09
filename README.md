# Raffle Monorepo

## Introduction

This project is the mono repository of the Raffle application and supporting infrastructure.

The application is being designed around the following architectural principles:

- Domain-Driven Design (DDD)
- Event-Driven Architecture (EDA)
- Command Query Responsibility Segregation (CQRS)
- Event Sourcing
- Hexagonal Architecture

## Project Structure

The repository is organised into a number of areas that will support the Raffle application - see documentation below:

- [Shared](./shared/README.md)

## Getting Started

The project provides Make targets for managing the local docker environment.

To start the current environment:
```shell
make start
```

To stop it:
```shell
make stop
```
To destroy the local environment:
```shell
make destroy
```
To see all available commands:
```shell
make help
```
