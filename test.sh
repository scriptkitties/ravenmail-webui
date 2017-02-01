#! /usr/bin/env sh

readonly PHPUNIT=./vendor/bin/phpunit
readonly PHPMD=./vendor/bin/phpmd

prepare() {
	php artisan cache:clear && \
		composer dump-autoload
}

refresh() {
	php artisan migrate:refresh --seed
}

unit() {
	${PHPUNIT}
}

code() {
	${PHPMD} \
		app text cleancode,codesize,controversial,design,naming,unusedcode
}

main() {
	if [ $# = 0 ]
	then
		prepare && refresh && unit && code && exit 0
	fi

	for i in "$@"
	do
		$i
	done
}

main "$@"

