.DEFAULT_GOAL := default

.PHONY:
	install clean docker-clean default

install:
	@echo "Building Docker Containers..."
	docker-compose up -d --build;
	docker exec -it chronos-pipeline_php_1 ./start.sh;

clean:
	@echo "Cleaning Docker Containers..."
	docker exec -it chronos-pipeline_php_1 ./stop.sh;
	docker-compose down;

migrate:
	@echo "Migrating the Database...";
	docker exec -it chronos-pipeline_pipelinedb_1 psql -U pipeline -c "CREATE DATABASE postgres ENCODING 'LATIN1' TEMPLATE template0 LC_COLLATE 'C' LC_CTYPE 'C';";
	docker exec -it chronos-pipeline_php_1 bin/console doctrine:migrations:migrate;

seed:
	@echo "Seeding Data...";
	@docker exec -it chronos-pipeline_php_1 bin/console doctrine:fixtures:load --group=item;

test:
	@echo "Running Tests...";
	@docker exec -it chronos-pipeline_php_1 bin/phpunit --coverage-text

default:
	@echo ""
	@echo ""
	@echo "These options are available:"
	@echo ""
	@echo ""
	@echo "1. make install (Installs the Application)"
	@echo "2. make migrate (Creates the Application Database)"
	@echo "3. make seed (Seed the Database using Fixtures)"
	@echo "4. make test (Runs the Application Tests)"
	@echo "5. make clean (Uninstalls the Application)"
	@echo ""
	@echo ""