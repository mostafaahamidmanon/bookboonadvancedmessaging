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

default:
	@echo ""
	@echo ""
	@echo "These options are available:"
	@echo ""
	@echo ""
	@echo "1. make install"
	@echo "2. make clean"
	@echo ""
	@echo ""