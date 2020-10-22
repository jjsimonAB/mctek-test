FROM redis:3.2-alpine

COPY redis.conf /usr/local/etc/redis/redis.conf
COPY data/dafaultData.txt /usr/local/etc/redis/
CMD ["redis-server", "/usr/local/etc/redis/redis.conf"]

EXPOSE 6379