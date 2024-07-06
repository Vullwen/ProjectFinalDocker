#!/bin/bash

BACKEND_IMAGE="vullwen/backend"
FRONTEND_IMAGE="vullwen/frontend"
BACKEND_TAG="latest"
FRONTEND_TAG="latest"

set -x

docker pull ${BACKEND_IMAGE}:${BACKEND_TAG}
docker pull ${FRONTEND_IMAGE}:${FRONTEND_TAG}

cat <<EOF > docker-compose.yml
version: '3.8'
services:
  backend:
    image: ${BACKEND_IMAGE}:${BACKEND_TAG}
    volumes:
      - ./Backend:/var/www/html
    ports:
      - "8080:80"
    networks:
      - app-network

  frontend:
    image: ${FRONTEND_IMAGE}:${FRONTEND_TAG}
    volumes:
      - ./Frontend:/var/www/html
    ports:
      - "8081:80"
    networks:
      - app-network

  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: mdp
      MYSQL_DATABASE: BDDPCS
    volumes:            
      - db-data:/var/lib/mysql
      - ./Database:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"
    networks:
      - app-network

networks:
  app-network:
    driver: bridge

volumes:
  db-data:
EOF

docker-compose up -d

docker-compose logs -f
