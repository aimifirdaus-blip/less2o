FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set Apache to listen on $PORT (dynamic port)
ENV PORT 8000
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Expose the dynamic port
EXPOSE $PORT

# Start Apache in foreground
CMD ["apache2-foreground"]
