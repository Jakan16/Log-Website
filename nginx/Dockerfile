FROM nginx
RUN rm /etc/nginx/conf.d/*
COPY reverse-proxy.conf /etc/nginx/conf.d/tmp

#RUN mkdir /etc/nginx/sites-enabled
#RUN ln -s /etc/nginx/sites-available/reverse-proxy.conf /etc/nginx/sites-enabled/reverse-proxy.conf