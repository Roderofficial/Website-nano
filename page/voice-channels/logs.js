function actionformat(value) {
    if(value == 1){
        return '<i class="fas fa-walking"></i> join';
    }else if (value == 0){
        return '<i class="fas fa-sign-out-alt"></i> leave';
    }
}
function rowStyle(row, index) {
    if(row.action == 1){
        return {
            classes: 'bg-light text-dark'
        }
    }else if (row.action == 0){
        return {
            classes: 'bg-dark text-white'
        }
    }
}

function timecontrol(value) {
    return timeconvert(value);
}
function channelstyle(value){
    return '<i class="fas fa-microphone-alt"></i> ' + value
}