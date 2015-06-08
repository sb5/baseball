
FROM ubuntu:14.04

MAINTAINER Steve B <steve.breighner@gmail.com>

RUN apt-get update
RUN apt-get install -y nodejs npm

COPY ./src /src


RUN cd /src; npm install; npm install ejs



EXPOSE 8080



CMD ["nodejs", "/src/index.js"]


FROM    centos:6.4

# Enable EPEL for Node.js
RUN     rpm -Uvh http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
# Install Node.js and npm
RUN     yum install -y npm

# App
ADD . /src
# Install app dependencies
RUN cd /src; npm install

EXPOSE  8080
CMD ["node", "/src/index.js"]