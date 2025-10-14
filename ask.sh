DB_NAME=dbsql1
DB_USER=dbsql1
DB_PASSWORD=passpass
DATE=$(date +"%F")


echo -e "I'm ask.sh. What you like to do?, enter a Task Id from list below: \n"
echo -e "TaskID\t Description"
echo -e "1\t Export Db - Export the database on the docker/test server"
echo -e "2\t Rename WP - Rename the database on the docker server"
echo -e "3\t Clean Docker - Clean the docker containers and volumes "
echo -e "4\t Clean All - Clean the docker containers and volumes and images "
echo -e "5\t WPCLI - Get into Wp cli "
echo -e "6\t Gen PHP docs - Generate php docs into pages/public/docs "
echo -e "7\t Run - Docker Test Enviroment "


read task

if [ "$task" = "1" ]; then
    echo "...execute task ${task} | file ./em.sh"
     docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "./test/init/${DB_NAME}-${DATE}.sql.gz"
     docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "./test/init/${DB_NAME}.sql.gz"

elif [ "$task" = "2" ]; then
    echo "...execute task ${task} | "
    cd test/wordpress/
    wp search-replace "https://en.app.local" "https://app.local"  --skip-columns=guid
    
elif [ "$task" = "3" ]; then
    echo "...execute task ${task} | clean all"    
    docker rm --force `docker ps -qa`
    docker volume rm $(docker volume ls -q --filter dangling=true)
    docker network prune
    
elif [ "$task" = "4" ]; then
    echo "...execute task ${task} | clean all"
    docker rm --force `docker ps -qa`
    docker volume rm $(docker volume ls -q --filter dangling=true)
    docker network prune
    docker rmi --force `docker images -aq`    

elif [ "$task" = "5" ]; then
    echo "... ${task} -- go into wpcli docker"
    cd test/wordpress
    docker exec -it wpcli bash
    
elif [ "$task" = "6" ]; then
    echo "... ${task} -- generate php docs"
    phpDocumentor run -d  test/wordpress/wp-content/plugins/domain-translate/  -t pages/public/docs/

elif [ "$task" = "7" ]; then
    echo "... ${task} -- Run Docker Test"
    cd test
    docker-compose up -d
else
    echo "Goodbye! - Exit"
fi


