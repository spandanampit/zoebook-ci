rm -Rf /var/www/html/application/cache/*
find /var/www/html/public/upload/compress_video/ -mtime +5 -exec rm -Rf {} \;
find /var/www/html/public/upload/covervideo_thumbnail/ -mtime +5 -exec rm -Rf {} \;
find /var/www/html/application/logs/ -mtime +15 -exec rm -Rf {} \;
