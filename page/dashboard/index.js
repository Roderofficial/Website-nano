function update(){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            encoded_data = JSON.parse(xmlHttp.responseText);
            update_user_and_members(encoded_data.online, encoded_data.members);
            update_chart(1, encoded_data.chart);
        } else if(xmlHttp.readyState == 4 && xmlHttp.status == 204){
            update_user_and_members('N/A','N/A');
            update_chart(0);
        }

    }
    xmlHttp.open("GET", "data.php", true);
    xmlHttp.send(null);
}
function update_user_and_members(online, members){
    document.getElementById("users_label").innerHTML = members;
    document.getElementById("online_users_label").innerHTML = online;
}
function update_chart(state,chdata){
    if(state == 1){
        //DATA FOR CHART
        const data = {
            labels: chdata.labels,
            datasets: [
                {
                    label: 'Total online',
                    borderColor: 'rgb(0, 119, 255)',
                    data: chdata.data.all_online,
                },
                {
                    label: 'Status: Online',
                    borderColor: 'rgb(8, 189, 56)',
                    data: chdata.data.online,
                },
                {
                    label: 'Status: Do Not Disturb',
                    borderColor: 'rgb(181, 22, 11)',
                    data: chdata.data.dnd,
                },
                {
                    label: 'Status: Idle',
                    borderColor: 'rgb(255, 209, 3)',
                    data: chdata.data.idle,
                }

                ]
        };
        const config = {
            legend: {
                labels: {
                    fontColor: "#fff",
                }
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            callback: function(value){
                                return hourconvert(value);
                            }
                        }
                    }]
                }
            },

            type: 'line',
            data: data,

        };

        $('#mainchart').html('<canvas id="canvaschart"></canvas>');
        var myChart = new Chart(
            document.getElementById('canvaschart'),
            config
        );

    }else{
        $('#mainchart').html(`
            <div class="text-center">
                <i class="fas fa-times" style="font-size:64px;"></i>
                <p style="margin-bottom:0px;">No data to display.</p>
              </div>
        `);
    }

}

function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time_label').innerHTML = h + ":" + m + ":" + s;
    setTimeout(startTime, 1000);
}

function checkTime(i) {
    if (i < 10) { i = "0" + i }; 
    return i;
}
window.addEventListener('load', (event) => {
    startTime();
    update();
});





