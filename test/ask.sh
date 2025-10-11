echo -e "What you like to do?, enter a Task Id from list below: \n"
echo -e "TaskID\tFile\t\tDescription"
echo -e "1\t./ed.sh\t\texport the database on the docker/test server"
echo -e "2\t./im.sh\t\timport the database on the develop/test server"
echo -e "7\t./rd.sh\t\trename the database on the docker server"
echo -e "8\t./clean.sh\tclean the docker containers and volumes "
echo -e "9\t./wpcli\t get into Wp cli "


read task

if [ "$task" = "1" ]; then
    echo "...execute task ${task} | file ./em.sh"
    ./ask.d/ed.sh
elif [ "$task" = "2" ]; then
    echo "...execute task ${task} | file ./im.sh"
    ./ask.dim.sh
elif [ "$task" = "3" ]; then
    echo "...execute task ${task} | file ./ep.sh"
    ./ep.sh
elif [ "$task" = "4" ]; then
    echo "...execute task ${task} | file ./ip.sh"
    ./ip.sh
elif [ "$task" = "5" ]; then
    echo "...execute task ${task} | file ./rm.sh"
    ./rm.sh
elif [ "$task" = "6" ]; then
    echo "...execute task ${task} | file ./rp.sh"
    ./rp.sh
elif [ "$task" = "7" ]; then
    echo "...execute task ${task} | file ./rd.sh"
   ./rd.sh    
elif [ "$task" = "8" ]; then
    echo "...execute task ${task} | file ./clean.sh"
    ./ask.d/clean.sh

elif [ "$task" = "9" ]; then
    echo "... ${task} -- go into wpcli docker"
    cd wordpress
    docker exec -it wpcli bash 
else
    echo "Goodbye! - Exit"
fi
