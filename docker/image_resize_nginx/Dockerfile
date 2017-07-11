FROM ubuntu:14.04

MAINTAINER tatsuki.nakagawa

ENV PATH $PATH:/usr/bin
ENV DEBIAN_FRONTEND noninteractive

# Avoid ERROR: invoke-rc.d: policy-rc.d denied execution of start.
RUN sed -i "s/^exit 101$/exit 0/" /usr/sbin/policy-rc.d

RUN apt-get update

RUN apt-get install -y nginx

CMD ["nginx", "-g", "daemon off;"]
