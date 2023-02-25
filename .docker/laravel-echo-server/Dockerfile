FROM node:14-alpine3.13

USER root

WORKDIR /var/www/html

COPY package.json package-lock.json webpack.mix.js laravel-echo-server.json .env ./

RUN npm install

RUN npm install -g laravel-echo-server

EXPOSE 6001

CMD ["laravel-echo-server","start","-p","6001"]