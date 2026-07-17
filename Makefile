start:
	docker compose up -d
	php -S localhost:8000 -t public

stop:
	docker compose down

test:
	php tests/security_test.php
	php tests/business_rules_test.php
