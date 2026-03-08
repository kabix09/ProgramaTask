# Task Management System - Recruitment Task

A robust Headless API solution built with **Symfony 7.4**, designed with scalability and clean architecture in mind. This project implements **Domain-Driven Design (DDD)**, **CQRS**, and **Event Sourcing** patterns.

![Homepage Screenshot](./public/img.png)

Contents
========
 * [Architecture & Patterns](#architecture--patterns)
 * [Technologies](#technologies)
 * [Get Started](#get-started)
 * [Usage](#usage)
 * [GraphQL API Examples](#graphql-api-examples)
  
## Architecture & Patterns
This project follows software engineering standards like:
* **Domain-Driven Design (DDD):** Clear separation between Domain, Application, and Infrastructure layers.
* **CQRS:** Separation of write operations (Commands) and read operations (Queries) using Symfony Messenger.
* **Event Sourcing / Audit Trail:** Every state change in `Task` or `User` entities generates a Domain Event stored in the `event_store`.
* **Strategy Pattern:** Used for flexible and extensible task status validation.

## Technologies
* [PHP 8.2+](https://www.php.net/)
* [Symfony 7.4](https://symfony.com/)
* [PostgreSQL 16](https://www.postgresql.org/)
* [GraphQL (OverblogBundle)](https://github.com/overblog/GraphQLBundle)
* [Docker & Docker Compose](https://www.docker.com/)
* [Bootstrap 5](https://getbootstrap.com/)

## Get started
The project is fully containerized. You don't need PHP or Postgres installed locally.

1. **Clone the repository**
```bash
   git clone https://github.com/kabix09/ProgramaTask.git
   cd ProgramaTask
```

2. **Environment Configuration**

   The project uses `.env` for defaults. You can create a `.env.local` to override settings (e.g., ports), but it is configured to work out-of-the-box.


4. **Build and Start with Docker**

```bash
docker compose up -d --build
```

*The containers will automatically run migrations and wait for the database to be ready.*

## Usage

Once the containers are running, you can access the following endpoints:

* **Landing Page:** [http://localhost:8080](https://www.google.com/search?q=http://localhost:8080)
* **GraphQL Explorer (GraphiQL):** [http://localhost:8080/graphiql](https://www.google.com/search?q=http://localhost:8080/graphiql)
* **API Endpoint:** `http://localhost:8080/graphql` (POST)

## GraphQL API Examples

### Sync Users from External API

```graphql
mutation {
  syncUsers
}
```

### Create a New Task

```graphql
mutation {
  createTask(
    title: "Zaimplementować GraphQL ",
    description: "Dodać Query i Mutacje do projektu "
  ) {
    id
    title
    status
  }
}
```

### Change Task Status

```graphql
mutation {
  changeTaskStatus(
    id: "uuid-here", 
    status: DONE
   ) {
    id
    status
  }
}
```

### Get All Tasks with Events

```graphql
query {
  allTasks {
    id
    title
    status
    description
    user {
      id
      name
      email
    }
  }
}
```
