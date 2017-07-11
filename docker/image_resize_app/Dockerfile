FROM ubuntu:14.04

MAINTAINER tatsuki.nakagawa

ENV PATH $PATH:/usr/bin
ENV DEBIAN_FRONTEND noninteractive

# Avoid ERROR: invoke-rc.d: policy-rc.d denied execution of start.
RUN sed -i "s/^exit 101$/exit 0/" /usr/sbin/policy-rc.d

RUN apt-get update
RUN apt-get -y install apt-file
RUN apt-file update
RUN apt-file search add-apt-repository
RUN apt-get -y install software-properties-common
RUN apt-get install -y language-pack-en-base
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys E5267A6C
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-get update
RUN apt-get -y install php5.6 php5.6-mcrypt php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-gd php5.6-intl php5.6-xsl php5.6-zip php5.6-fpm

COPY ./launch.sh /launch.sh
# CMDだとコンテナが落ちるが、ENTRYPOINTだと落ちない
ENTRYPOINT [ "/bin/bash", "/launch.sh"]
