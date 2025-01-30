up:
	@docker compose up --build -d

down:
	@docker compose down
	@docker volume rm tradein_dbdata
