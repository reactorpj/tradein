docker-up:
	@docker compose up --build -d

docker-down:
	@docker compose down --remove-orphans
	@docker volume rm tradein_dbdata

composer-install:
	@docker compose exec php composer install --no-interaction

doctrine-init:
	@docker compose exec php bin/console doctrine:migrations:migrate -q

doctrine-fixtures:
	@docker compose exec php bin/console doctrine:fixtures:load -q
cars:
	@echo http://localhost:80/api/v1/cars
	@docker exec -it nginx curl http://localhost:80/api/v1/cars | jq

car:
	@echo http://localhost:80/api/v1/cars/1
	@docker exec -it nginx curl http://localhost:80/api/v1/cars/1 | jq

credit:
	@echo http://localhost:80/api/v1/credit/calculate\?initialPayment\=20000\&price\=35000\&loanTerm\=35
	@docker exec -it nginx curl http://localhost:80/api/v1/credit/calculate\?initialPayment\=20000\&price\=35000\&loanTerm\=35 | jq

request:
	@echo http://localhost:80/api/v1/request
	@docker exec -it nginx curl -X POST -H "Content-Type: application/json" -d '{"carId": 1, "programId":1, "initialPayment":10000, "loanTerm":40}' http://localhost:80/api/v1/request | jq
	@docker exec -it db mysql -u root -proot -D trade -e "select * from credit_request" --table


test:
	docker exec -it php bin/phpunit


init: docker-up composer-install doctrine-init doctrine-fixtures
down: docker-down

