default:
	@make test

# make TAG_VERSION=1.0.0 tag
tag:
	@echo '$(TAG_VERSION)' > VERSION.txt
	@git add .
	@git commit -a -m 'v$(TAG_VERSION)'
	@git tag v$(TAG_VERSION)

test:
	@echo 'Running tests...'
	@phpunit --coverage-html=tests/coverage --verbose
	@echo 'Done.'
