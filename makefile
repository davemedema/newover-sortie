default:
	@echo 'Running tests...'
	@phpunit --coverage-html=tests/coverage --verbose
	@echo 'Done.'
