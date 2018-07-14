echo "loading..."
pid = `pidof live_master`
kill -USR1 $pid
echo "loading success"