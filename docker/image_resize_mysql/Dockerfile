FROM ubuntu:14.04

MAINTAINER tatsuki.nakagawa

ENV PATH $PATH:/usr/bin

RUN apt-get update

RUN apt-get install -y mysql-server

CMD service mysql start && tail -F /var/log/mysql/error.log
