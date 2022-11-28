/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

function sendmail(id_user){
    const request = new XMLHttpRequest();

    request.open("GET", "/ajax/sendmail.php?id_user="+id_user+"&mail_file=recent_purchase.php");

    request.send();

}