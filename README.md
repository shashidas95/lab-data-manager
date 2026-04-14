This project is impressive because it showcases **DevOps and Containerization** skills. You aren't just writing code; you are orchestrating an entire environment with **Docker**, **Nginx**, and a **Vue.js/PHP** stack.

To get the best score for this repo, the README needs to emphasize the **Infrastructure-as-Code (IaC)** aspect.

-----

# 🧪 Lab Data Manager

[](https://www.docker.com/)
[](https://www.nginx.com/)
[](https://vuejs.org/)
[](https://www.php.net)

A containerized Laboratory Data Management System designed for high availability and easy deployment. This project demonstrates a full-stack implementation using a **microservices-oriented architecture**, managed entirely via Docker Compose.

## 🏗 System Architecture

The application is split into specialized containers to ensure scalability and separation of concerns:

  * **App Container:** Handles the core business logic using PHP 8.x.
  * **Frontend Container:** A modern reactive interface built with **Vue.js**.
  * **Web Server (Nginx):** Acts as a reverse proxy, efficiently routing traffic to the frontend and backend services.
  * **Database (MySQL):** Persistent storage for laboratory records, results, and user data.

## 🛠 Features

  * **Docker-First Workflow:** Entire environment can be spun up with a single command.
  * **Reactive UI:** Fast, component-based user interface for managing lab data.
  * **Nginx Configuration:** Custom Nginx setup for handling request routing and static file serving.
  * **Persistence:** Volume-mapped database storage to ensure lab data is preserved across container restarts.

## 🚀 Deployment & Installation

The biggest advantage of this project is the simplified setup.

### Prerequisites

  * Docker & Docker Compose installed on your machine.

### One-Command Setup

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/shashidas95/lab-data-manager.git
    cd lab-data-manager
    ```

2.  **Launch the stack:**

    ```bash
    docker-compose up -d --build
    ```

The system will automatically build the images, configure the network, and start the services. You can then access the application at `http://localhost`.

## 📂 Project Structure

  * `/src`: Backend source code (PHP).
  * `/frontend`: Frontend source code (Vue.js).
  * `/nginx`: Configuration files for the web server.
  * `/mysql`: Initial database setup scripts.
  * `docker-compose.yml`: The orchestration manifest.

-----
