.DEFAULT_GOAL := default

.PHONY:
	install clean docker-clean default

install:
	@echo "Building Docker Containers..."
	@docker-compose up -d --build;
	@docker exec -it chronos-pipeline_php_1 ./start.sh;
	@./rmt.phar init

clean:
	@echo "Cleaning Docker Containers..."
	@docker exec -it chronos-pipeline_php_1 ./stop.sh;
	@docker-compose down;

migrate:
	@echo "Migrating the Database...";
	@docker exec -it chronos-pipeline_pipelinedb_1 psql -U pipeline -c "CREATE DATABASE postgres ENCODING 'LATIN1' TEMPLATE template0 LC_COLLATE 'C' LC_CTYPE 'C';";
	@docker exec -it chronos-pipeline_php_1 bin/console doctrine:migrations:migrate;

seed:
	@echo "Seeding Data...";
	@docker exec -it chronos-pipeline_php_1 bin/console doctrine:fixtures:load --group=item;

consume:
	@echo "Consuming Messages...";
	@docker exec -it chronos-pipeline_php_1 bin/console messenger:consume async;

docs:
	@echo "Generating Docs...";
	@docker exec -it chronos-pipeline_php_1 ./vendor/bin/openapi src/Item;

test:
	@echo "Running Tests...";
	@docker exec -it chronos-pipeline_php_1 bin/phpunit --coverage-text;

release:
	@echo "Please make sure that composer is installed";
	@echo "Creating a Release...";
	@./rmt.phar release;

meinphp:
	@echo "Entring PHP Container...";
	@docker exec -it chronos-pipeline_php_1 sh;

meinpipeline:
	@echo "Entring in PipelineDB Container...";
	@docker exec -it chronos-pipeline_pipelinedb_1 sh;

meinkafka:
	@echo "Entring in Kafka Container...";
	@docker exec -it chronos-pipeline_kafka_1 sh;

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
	@echo "5. make docs (Generates the documentation)"
	@echo "6. make clean (Uninstalls the Application)"
	@echo "7. make meinphp (Accesses PHP Container)"
	@echo "8. make meinkafka (Accesses Kafka Container)"
	@echo "9. make meinpipeline (Accesses PipelineDB Container)"
	@echo ""
	@echo ""