# Docker Stack

Simple PHP app with Nginx and MySQL using Docker.

## Run
```bash
docker compose up -d --build  # first time
```
```bash
docker compose up -d          # normal use
```

## Access
http://localhost:8080

## Setup Database
```bash
docker exec -it <mysql_container_name> mysql -u <db_user> -p
```

Enter password: <db_password>


## Example Database
```sql
USE <db_name>;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, role) VALUES
('MingMing', 'mingming123@gmail.com', 'admin'),
('Kuku', 'kuku123@gmail.com', 'user'),
('Koko', 'koko123@gmail.com', 'user'),
('Kaka', 'kaka123@gmail.com', 'user'),
('Keke', 'keke123@gmail.com', 'user'),
('Jingjork', 'jingjork@gmail.com', 'user');
```
