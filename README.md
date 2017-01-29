# tyil.email frontend
This is the frontend to manage all the domains on tyil.email. It is made to be
used in conjunction with the [FreeBSD email server tutorial][email-tutorial].

## Installation
### PHP
```
pkg install \
	php70 \
	php70-ctype \
	php70-dom \
	php70-filter \
	php70-hash \
	php70-json \
	php70-mbstring \
	php70-mcrypt \
	php70-openssl \
	php70-phar \
	php70-session
```

If you followed the [tutorial to set up the email server][email-tutorial],
`php70-pdo_pgsql` will not install by default, so you will need to compile the
port instead:

```
cd /usr/ports/databases/php70-pdo_pgsql
make install clean
```

Do not forget to enable php-fpm and start it:

```
echo 'php_fpm_enable="YES"' >> /etc/rc.conf.local
service php-fpm start
```

### Nginx
Next up you can configure [nginx][nginx] to host the website. Add the following
content to `/usr/local/etc/nginx/sites/frontend.conf`:

```
# redirects
server {
	# listeners
	listen      80;
	server_name domain.tld *.domain.tld;

	# redirects
	return 301 https://$host$request_uri;
}

server {
	# listeners
	listen      443 ssl;
	server_name domain.tld;

	# redirect
	return 301 https://www.domain.tld$request_uri;

	# headers
	add_header Strict-Transport-Security "max-age=31536000; includeSubdomains; preload";

	# keys
	ssl_certificate      /usr/local/etc/letsencrypt/live/domain.tld/fullchain.pem;
	ssl_certificate_key  /usr/local/etc/letsencrypt/live/domain.tld/privkey.pem;
}


# HTTPS
server {
	# listeners
	listen       443 ssl;
	server_name  www.domain.tld;

	# site path
	root  /srv/www/frontend/public;
	index index.php;

	# / handler
	location / {
		try_files $uri $uri/ =404;
	}

	# .php handler
	location ~ \.php$ {
		try_files      $uri /index.php =404;
		fastcgi_pass   127.1:9000;
		fastcgi_index  index.php;
		fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include        fastcgi_params;
	}

	# enable HSTS
	add_header  Strict-Transport-Security "max-age=31536000; includeSubdomains; preload";

	# keys
	ssl_certificate      /usr/local/etc/letsencrypt/live/domain.tld/fullchain.pem;
	ssl_certificate_key  /usr/local/etc/letsencrypt/live/domain.tld/privkey.pem;
}
```

Once the configuration file has been written you can reload nginx for the new configuration.

```
service nginx reload
```

### Application
If you do not have [Composer][composer] yet, set this up now. Afterwards, clone
this repository and install all php dependencies from [Laravel][laravel]:

```
mkdir -p /srv/www
git clone https://c.darenet.org/tyil/website-mail.git /srv/www/frontend
cd $_
composer install
chown -R www:www .
```

---

[![Build Status](https://travis-ci.org/scriptkitties/ravenmail-webui.svg?branch=master)](https://travis-ci.org/scriptkitties/ravenmail-webui)
[![Code Climate](https://codeclimate.com/github/scriptkitties/ravenmail-webui/badges/gpa.svg)](https://codeclimate.com/github/scriptkitties/ravenmail-webui)

[email-tutorial]: https://www.tyil.work/tutorials/setup-imap-mailserver-on-freebsd.html
[laravel]: https://www.laravel.com/
[composer]: https://getcomposer.org/
[nginx]: http://nginx.com/

